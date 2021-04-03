<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;

class Status extends \yii\base\Widget
{

    public $status;

    public function run()
    {
        echo $this->render("//widget/_status", [
            'status' => $this->status,
            'class'  => $this->detectClass(),
        ]);
    }

    protected function detectClass()
    {
        $class = 'label';
        $map = [
            'label-error'      => ['error'],
            'label-waiting'    => ['wait'],
            'label-processing' => ['proc'],
            'label-finished'   => ['finish'],
        ];
        $status = strtolower($this->status);
        foreach ($map as $subClass => $matches) {
            foreach ($matches as $match) {
                if (strpos($status, $match) !== false) {
                    $class .= ' ' . $subClass;
                    return $class;
                }
            }
        }
        return $class;
    }
}
