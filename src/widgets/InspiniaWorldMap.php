<?php
/**
 * Created by PhpStorm.
 * User: AmorPro
 * Date: 15.12.2017
 * Time: 15:36
 */

namespace app\widgets;


use yii\bootstrap\Widget;
use yii\web\View;

class InspiniaWorldMap extends Widget
{
    public static $autoIncrement = 1;

    public $height    = 300;
    public $countries = [];

    public function run()
    {
        $id = 'world-map' . self::$autoIncrement++;
        $minValue = 0;

        if (!empty($this->countries)) {
            $minValue = min($this->countries);
        }

        if ($minValue < 0) {
            $minValue = 0;
        }

        $jsonCountries = json_encode($this->countries);

        $this->view->registerJsFile('/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js');
        $this->view->registerJsFile('/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
        $this->view->registerJs("
            var mapData = {$jsonCountries};
            $(document).ready(function(){
                $('#{$id}').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: 'transparent',
                    regionStyle: {
                        initial: {
                            'fill': '#e4e4e4',
                            'fill-opacity': 1,
                            'stroke': 'none',
                            'stroke-width': 0,
                            'stroke-opacity': 0
                        }
                    },
                    series: {
                        regions: [{
                            values: mapData,
                            scale: ['#cbfbf0', '#19aa8a'],
                            normalizeFunction: 'polynomial',
                            min: {$minValue}
                        }]
                    },
                    onRegionTipShow: function(e, el, code){
                        if (typeof mapData[code] === 'undefined') {
                            el.html(el.html());
                        } else {
                            el.html(el.html()+'<br>Income $'+parseInt(mapData[code]).formatMoney()+'');
                        }
                    }
                });
            });
        ",View::POS_READY);
        return "<div id='{$id}' style='height: {$this->height}px;'></div>";
    }


}

