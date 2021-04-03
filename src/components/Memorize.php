<?php
namespace backend\components;

trait Memorize
{
    protected static $memory = [];

    /**
     * @param $key
     * @param $args
     * @param callable $instantiateCallback
     * @return mixed
     * @throws \Exception
     */
    protected function _memorize($key, $args, $instantiateCallback){
        return self::_memorizeStatic($key, $args, $instantiateCallback);
    }

    /**
     * @param $key
     * @param $args
     * @param callable $instantiateCallback
     * @return mixed
     */
    protected static function _memorizeStatic($key, $args, $instantiateCallback){
        if (is_callable($args)) {
            $instantiateCallback = $args;
            $args = [];
        }
        $key = get_called_class() . $key . md5(serialize($args));
        if(!array_key_exists($key, self::$memory)){
            self::$memory[$key] = $instantiateCallback($args);
        }
        return self::$memory[$key];
    }

    protected function _memorizeIdentity($key, $ids, $instantiateCallback)
    {
        $key = get_called_class() . $key;

        if(!is_array(self::$memory[$key])){
            self::$memory[$key] = [];
        }

        // Fill the result with values already in cache
        $result = array_fill_keys($ids, null);
        $unknownIds = [];
        foreach ($ids as $id) {
            if (array_key_exists($id, self::$memory[$key])) {
                $result[$id] = self::$memory[$key][$id];
            } else {
                $unknownIds[] = $id;
            }
        }
        if (!$unknownIds) {
            return $result;
        }

        // Request the ids who is not in the cache
        $unknownIdsValues = $instantiateCallback($unknownIds);
        if(!is_array($unknownIdsValues)){
            $unknownIdsValues = [];
        }

        // Save the result to cache
        foreach ($unknownIds as $id) {
            self::$memory[$key][$id] = $unknownIdsValues[$id];
            $result[$id]             = $unknownIdsValues[$id];
        }
        return $result;

    }


}