<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 25.10.16
 * Time: 10:55
 */

namespace app\widgets;
use yii\grid\GridView;
use yii\helpers\Inflector;

/**
 * to make row clickable, add 'clickable-row' class to rowOptions
*/
class InspiniaGrid extends GridView {

    public $dataColumnClass = '\app\extensions\yii\grid\DataColumn';
    public $summary = '';
    public $tableOptions = ['class' => 'table table-stripped table-hover table-pointer toggle-arrow-tiny default'];
    public $footerCallback;

    public function init(){
        parent::init();
        if(!$this->rowOptions){
            $this->rowOptions = function ($model, $key, $index, $grid){
                $class=$index%2?'footable-odd':'footable-even';
                return [
                    'class'=>$class
                ];
            };
        }
    }

    /**
     * @inheritdoc
     * Added the ability to specify class name in the column name
     * @example 'total.total-column' => [
                    'attribute' => 'total.total-column',
                    'label' => 'Total',
                    'contentOptions' => ['class' => 'total-column'],
                ]
     */
    protected function guessColumns()
    {
        $models = $this->dataProvider->getModels();
        $model = reset($models);
        if (is_array($model) || is_object($model)) {
            foreach ($model as $name => $value) {
                if ($value === null || is_scalar($value) || is_callable([$value, '__toString'])) {
                    if (strpos($name, '.') !== false) {
                        $columnSpecification = explode('.', $name);

                        $column = [
                            'attribute' => $name,
                            'label' => Inflector::camel2words(array_shift($columnSpecification)),
                            'contentOptions' => ['class' => $columnSpecification],
                        ];

                        if ($this->footerCallback && $this->footerCallback instanceof \Closure) {
                            $this->showFooter = true;
                            $column['footer'] = call_user_func($this->footerCallback, $name);
                        }

                        $this->columns[] = $column;
                    } else {
                        $this->columns[] = (string) $name;
                    }
                }
            }
        }
    }
}