<?php
namespace backend\components\seller;

use backend\components\repository\Currency;
use backend\models\SellerQuery;

class Fabric {

    public function create($sellerId, $currencyId, array $options)
    {
        $seller = $this->_getSeller($sellerId);
        $currency = $this->_getCurrency($currencyId);
        switch ($seller->type) {
            case None::TYPE:
                return new None($currency, $options);
            case Simple::TYPE:
                return new Simple($currency, $options);
            case Barrier::TYPE:
                return new Barrier($currency, $options);
            case Grow::TYPE:
                return new Grow($currency, $options);
            default:
                throw new \InvalidArgumentException('Unknown seller type: '.$seller->type);
        }
    }

    private function _getCurrency($currencyId)
    {
        $repository = new Currency();
        return $repository->getById($currencyId);
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