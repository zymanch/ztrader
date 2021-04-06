<?php
namespace backend\commands;

use backend\components\buyer;
use backend\components\seller;
use backend\components\repository\Course;
use backend\models\BuyerQuery;
use backend\models\TraderQuery;
use yii\console\Controller;

class TraderController extends Controller {

    public $from;
    public $to;
    public $trader_id;

    public function options($actionID)
    {
        switch ($actionID) {
            case 'test':
                return ['from','to','trader_id'];
            default:
                return [];
        }

    }

    public function actionTest()
    {
        $trader = TraderQuery::model()
            ->filterByTraderId($this->trader_id)
            ->one();
        if (!$trader) {
            throw new \InvalidArgumentException('Trader not found');
        }
        $fabric = new buyer\Fabric();
        $buyer = $fabric->create($trader->currency_id, $trader->buyer_id, $trader->getBuyerOptions());

        $fabric = new seller\Fabric();
        $seller = $fabric->create($trader->currency_id, $trader->seller_id, $trader->getSellerOptions());

        $from = new \DateTimeImmutable($this->from);
        $to = new \DateTimeImmutable($this->to);

        $interval = new \DateInterval('PT1S');
        $period = new \DatePeriod($from, $interval, $to);

        $course = new Course();
        $isBuyer = true;
        $buyTime = null;
        $money = 100;
        $buyCourse = null;
        foreach ($period as $now) {
            if ($isBuyer) {
                if ($buyer->isBuyTime($now)) {
                    $buyTime = $now;
                    $buyCourse = $course->get('btc',$now);
                    print $now->format('Y-m-d H:i:s').' > buy with price '.$buyCourse."\n";ob_flush();
                    $isBuyer = false;
                }
            } else {
                if ($seller->isSellTime($buyTime, $now)) {
                    $sellCourse = $course->get('btc',$now);
                    $money = $money * ($sellCourse/$buyCourse-2*0.075/100);
                    print $now->format('Y-m-d H:i:s').' > sell with price '.$sellCourse." [money ".round($money,2)."]\n";ob_flush();
                    $isBuyer = true;
                }
            }
        }
    }

}