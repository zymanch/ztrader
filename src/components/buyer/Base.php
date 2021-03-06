<?php
namespace backend\components\buyer;


use backend\models\Currency;
use yii\base\Model;

abstract class Base extends Model {

    /**
     * @var Currency
     */
    protected $_currency;

    public function __construct(Currency $currency, array $options)
    {
        $this->_currency = $currency;
        parent::__construct(array_intersect_key($options, $this->getAvailableConfigs()));
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
                case 'select':
                    $result[] = [$name, 'in', 'range'=>array_keys($config['values'])];
                    break;
                default:
                    $result[] = [$name,'safe'];
            }
        }
        return $result;
    }

    abstract public function getAvailableConfigs():array;

    abstract public function isBuyTime(\DateTimeImmutable $now):bool;

}
