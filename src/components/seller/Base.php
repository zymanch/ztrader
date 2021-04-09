<?php
namespace backend\components\seller;


use backend\models\Currency;
use yii\base\Model;

abstract class Base  extends Model{


    /**
     * @var Currency
     */
    protected $_currency;

    public function __construct(Currency $currency, array $options)
    {
        $this->_currency = $currency;
        parent::__construct($options);
    }

    public function rules()
    {
        $result = [];
        foreach ($this->getAvailableConfigs() as $name => $config) {
            switch ($config['type']??'safe') {
                case 'integer':
                    if (($config['step']??1)==1) {
                        $result[] = [$name, 'integer', 'min' => $config['min'] ?? null, 'max' => $config['max'] ?? null];
                    } else {
                        $result[] = [$name, 'safe'];
                    }
                    break;
                default:
                    $result[] = [$name,'safe'];
            }
            $result[] = [$name,$config['type']];
        }
        return $result;
    }


    abstract public function getAvailableConfigs():array;

    abstract public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool;

}
