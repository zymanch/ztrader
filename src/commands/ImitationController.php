<?php
namespace backend\commands;

use ActiveGenerator\Criteria;
use backend\components\buyer;
use backend\components\seller;
use backend\components\repository\Course;
use backend\models\BuyerQuery;
use backend\models\Trader;
use backend\models\TraderHistory;
use backend\models\TraderHistoryQuery;
use backend\models\TraderImitation;
use backend\models\TraderImitationQuery;
use backend\models\TraderQuery;
use yii\console\Controller;
use yii\helpers\Console;

class ImitationController extends Controller {

    public $defaultAction = 'run';

    public $trader_id;
    public $imitation_id;
    public $limit = 1;

    private $_buyId;

    public function options($actionID)
    {
        switch ($actionID) {
            case 'run':
                return ['limit','imitation_id','trader_id'];
            default:
                return [];
        }

    }

    public function actionRun()
    {
        for ($iteration=0;$iteration < $this->limit;$iteration++) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $imitation = TraderImitationQuery::model()
                    ->filterByStatus(TraderImitation::STATUS_WAITING)
                    ->forUpdate()
                    ->limit(1)
                    ->one();
                if (!$imitation) {
                    $this->stdout('Нет имитации для обработки',Console::FG_RED);
                    return;
                }
                $imitation->pid = getmypid();
                $imitation->status = TraderImitation::STATUS_PROCESSING;
                $imitation->save();
                $transaction->commit();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                $this->stdout('Ошибка получения ожидающей имитации: '.$e->getMessage(),Console::FG_RED);
                sleep(1);
                continue;
            }
            $this->_clearOldPeriod($imitation);
            $this->_runImitation($imitation);
        }

    }

    private function _runImitation(TraderImitation $imitation) {

        $trader = $imitation->trader;
        $fabric = new buyer\Fabric();
        $buyer = $fabric->create($trader->currency_id, $trader->buyer_id, $trader->getBuyerOptions());

        $fabric = new seller\Fabric();
        $seller = $fabric->create($trader->currency_id, $trader->seller_id, $trader->getSellerOptions());

        $from = new \DateTimeImmutable($imitation->from);
        $to = new \DateTimeImmutable($imitation->to);

        $interval = new \DateInterval('PT'.$imitation->tick_size.'S');
        $period = new \DatePeriod($from, $interval, $to);

        $course = new Course();
        $isBuyer = true;
        $buyTime = null;
        $money = 100;
        $buyCourse = null;
        $tickCount = $period->getRecurrences();
        foreach ($period as $index => $now) {
            if ($isBuyer) {
                if ($buyer->isBuyTime($now)) {
                    $buyTime = $now;
                    $buyCourse = $course->get('btc',$now);
                    $this->_onBuyLogs($now, $imitation, $buyCourse);
                    $this->_onBuyHistory($now, $imitation, $buyCourse);
                    $isBuyer = false;
                }
            } else {
                if ($seller->isSellTime($buyTime, $now)) {
                    $sellCourse = $course->get('btc',$now);
                    $money = $money * ($sellCourse/$buyCourse-2*0.075/100);
                    $this->_onSellLogs($now, $imitation, $sellCourse, $money);
                    $this->_onSellHistory($now, $imitation, $sellCourse, $money);
                    $buyId = null;
                }
            }
            if ($index%10==0) {
                $imitation->progress = round(100*$index/$tickCount);
                $imitation->save(false);
            }
        }
        $imitation->progress = 100;
        $imitation->status = TraderImitation::STATUS_FINISHED;
        $imitation->save(false);
    }

    private function _clearOldPeriod(TraderImitation $imitation)
    {
        $histories = TraderHistoryQuery::model()
            ->filterByTraderId($imitation->trader_id)
            ->filterByType(TraderHistory::TYPE_VIRTUAL)
            ->filterByDate(date('Y-m-d 00:00:00', strtotime($imitation->from)), Criteria::GREATER_EQUAL)
            ->filterByDate(date('Y-m-d 23:59:59', strtotime($imitation->to)), Criteria::LESS_EQUAL)
            ->orderByBuyTraderHistoryId(Criteria::ASC)
            ->all();
        foreach ($histories as $history) {
            $history->delete();
        }
    }

    private function _onBuyLogs(\DateTimeInterface $now, TraderImitation $imitation, $course)
    {
        $this->stdout($now->format('Y-m-d H:i:s').' > buy with price '.$course."\n");
    }


    private function _onSellLogs(\DateTimeInterface $now, TraderImitation $imitation, $course, $money)
    {
        $this->stdout($now->format('Y-m-d H:i:s').' > sell with price '.$course." [money ".round($money,2)."]\n");
    }
    private function _onBuyHistory(\DateTimeInterface $now, TraderImitation $imitation, $course)
    {
        $history = $this->_createHistory($now, $imitation, $course);
        $this->_buyId = $history->trader_history_id;
    }
    private function _onSellHistory(\DateTimeInterface $now, TraderImitation $imitation, $course, $money)
    {
        $this->_createHistory($now, $imitation, $course, $this->_buyId);
    }

    private function _createHistory(\DateTimeInterface $now, TraderImitation $imitation, $course, $buyId = null)
    {
        $history = new TraderHistory();
        $history->date = $now->format('Y-m-d H:i:s');
        $history->buy_trader_history_id = $buyId;
        $history->trader_id = $imitation->trader_id;
        $history->trader_imitation_id = $imitation->trader_imitation_id;
        $history->type = TraderHistory::TYPE_VIRTUAL;
        $history->action = $buyId ? TraderHistory::ACTION_SALE : TraderHistory::ACTION_BUY;
        $history->course = $course;
        $history->comission_percent = 0.075;
        $history->save();
        return $history;
    }

}