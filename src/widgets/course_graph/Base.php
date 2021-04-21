<?php
namespace app\widgets\course_graph;
use app\widgets\CourseGraph;
use yii\base\Component;

abstract class Base extends Component {

    /**
     * @var CourseGraph
     */
    protected $graph;

    public function __construct(CourseGraph $graph,$config = [])
    {
        parent::__construct($config);
        $this->graph = $graph;
    }
    abstract public function getDatasets();

}