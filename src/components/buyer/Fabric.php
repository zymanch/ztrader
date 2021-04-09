<?php
namespace backend\components\buyer;

use backend\components\repository\Currency;
use backend\models\BuyerQuery;

class Fabric {

    public function create($buyerId, $currencyId, array $options)
    {
        $buyer = $this->_getBuyer($buyerId);
        $currency = $this->_getCurrency($currencyId);
        switch ($buyer->type) {
            case None::TYPE:
                return new None($currency, $options);
            case Simple::TYPE:
                return new Simple($currency, $options);
            case Avg::TYPE:
                return new Avg($currency, $options);
            case Fall::TYPE:
                return new Fall($currency, $options);
            default:
                throw new \InvalidArgumentException('Unknown buyer type: '.$buyer->type);
        }
    }

    private function _getBuyer($buyerId)
    {
        $buyer = BuyerQuery::model()
            ->filterByBuyerId($buyerId)
            ->one();
        if (!$buyer) {
            throw new \InvalidArgumentException('Buyer not found');
        }
        return $buyer;
    }

    private function _getCurrency($currencyId)
    {
        $repository = new Currency();
        return $repository->getById($currencyId);
    }

}