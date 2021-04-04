<?php
namespace backend\components\buyer;

use backend\models\BuyerQuery;

class Fabric {

    public function create($buyerId, array $options)
    {
        $buyer = $this->_getBuyer($buyerId);
        switch ($buyer->type) {
            case Simple::TYPE:
                return new Simple($options);
            case Avg::TYPE:
                return new Avg($options);
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

}