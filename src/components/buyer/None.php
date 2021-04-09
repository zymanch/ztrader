<?php
namespace backend\components\buyer;

class None extends Base {

    const TYPE = 'none';

    public function getAvailableConfigs():array
    {
        return [];
    }

    public function isBuyTime(\DateTimeImmutable $now):bool
    {
        return false;
    }

}
