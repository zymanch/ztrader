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
    public $from = '2021-01-01';
    public $to;
    public $tick_size = 5;


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
        $model->from = $this->from.' 00:00:00';
        $model->to = $this->to.' 23:59:59';
        $model->status = TraderImitation::STATUS_WAITING;
        return $model->save();
    }

    public function attributeLabels()
    {
        return [
            'trader_id' => 'Трейдер',
            'from' => 'От даты',
            'to' => 'До даты',
            'tick_size' => 'Размер тика, сек',
        ];
    }

}
