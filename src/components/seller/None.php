<?php
namespace backend\components\seller;


class None extends Base {
    const TYPE = 'none';


    public function getAvailableConfigs():array
    {
        return [];
    }

    public function isSellTime(\DateTimeImmutable $buyTime, \DateTimeImmutable $now):bool
    {
        return false;
    }

}
