<?php
namespace backend\components\seller;

use backend\models\BuyerQuery;
use backend\models\SellerQuery;

class Fabric {

    public function create($sellerId, array $options)
    {
        $seller = $this->_getSeller($sellerId);
        switch ($seller->type) {
            case Simple::TYPE:
                return new Simple($options);
            case Avg::TYPE:
                return new Avg($options);
            default:
                throw new \InvalidArgumentException('Unknown seller type: '.$seller->type);
        }
    }

    private function _getSeller($buyerId)
    {
        $seller = SellerQuery::model()
            ->filterBySellerId($buyerId)
            ->one();
        if (!$seller) {
            throw new \InvalidArgumentException('Seller not found');
        }
        return $seller;
    }

}