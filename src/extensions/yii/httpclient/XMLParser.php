<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\extensions\yii\httpclient;

use yii\base\BaseObject;
use yii\httpclient\ParserInterface;
use yii\httpclient\Response;

/**
 * XmlParser parses HTTP message content as XML.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class XMLParser extends BaseObject implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(Response $response)
    {
        $body = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response->getContent());
        return json_decode(json_encode(simplexml_load_string($body)),1);
    }

}