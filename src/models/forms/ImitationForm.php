<?php
namespace backend\models\forms;

use backend\models\TraderImitation;
use yii\base\Model;

/**
 * Login form
 */
class ImitationForm extends Model
{
    public $trader_id;
    public $from;
    public $to;
    public $tick_size;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trader_id', 'from','to','tick_size'], 'required'],
            [['from','to'], 'date', 'format' => 'php:Y-m-d'],
            [['trader_id','tick_size'],'integer']
        ];
    }

    public function create() {
        $model = new TraderImitation();
        $model->trader_id = $this->trader_id;
        $model->from = $this->from;
        $model->to = $this->to;
        $model->status = TraderImitation::STATUS_WAITING;
        return $model->save();
    }

}
