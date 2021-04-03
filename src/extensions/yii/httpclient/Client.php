<?php


namespace app\extensions\yii\httpclient;


use backend\components\CsvParser;
use yii\base\Exception;

class Client extends \yii\httpclient\Client {

    const FORMAT_CSV = 'csv';

    protected $_requestMethod = 'GET';
    protected $_url;
    protected $_sslVerifyPeerDisabled = false;
    protected $_fromHost;
    protected $_vendoProtectionSecret;

    protected $_format;

    protected $_maxTimeLimit = 300;

    protected $_headers = [
        'User-Agent'    => 'StatAdmin/Version:2017.Dec.19',
        'Content-Type'  => 'application/x-www-form-urlencoded',
    ];

    public $parsers = [
        self::FORMAT_CSV => [
            'class' => CsvParser::class
        ]
    ];

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url) {
        $this->_url = $url;
        return $this;
    }

    /**
     * @param $secret
     * @return $this
     */
    public function setVendoProtection($secret) {
        $this->_vendoProtectionSecret = $secret;
        return $this;
    }
    /**
     * @param $host
     * @return $this
     */
    public function setFromHost($host) {
        if ($host) {
            $this->_headers['Host'] = $host;
        }
        return $this;
    }

    public function setUserAgent($userAgent) {
        $this->_headers['User-Agent'] = $userAgent;
        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodGet (){
        $this->_requestMethod = 'GET';
        return $this;
    }

    /**
     * @return $this
     */
    public function setMethodPost (){
        $this->_requestMethod = 'POST';
        return $this;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setFormat($format) {
        $this->_format = $format;
        return $this;
    }



    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function sendRequest($params = []) {
        if(!$this->_url){
            throw new Exception('URL can\'t be empty');
        }
        $params = $this->_prepareParams($params);
        switch ($this->_requestMethod){
            case 'GET':
                $request = $this->get($this->_url, $params, $this->_headers,['timeout'=>$this->_maxTimeLimit]);
                break;
            case 'POST':
                $this->_headers['Content-Length'] = strlen(is_string($params) ? $params : \http_build_query($params));
                $request = $this->post($this->_url, $params, $this->_headers,['timeout'=>$this->_maxTimeLimit]);
                break;
            default:
                throw new Exception(sprintf('Request method not supported: %s', $this->_requestMethod));
                break;
        }
        if($this->_sslVerifyPeerDisabled){
            $request->addOptions([
                'sslVerifyPeer' => false,
                'sslVerifyPeerName' => false
            ]);
        }
        $response = $request->send();
        if (!$response->getIsOk()) {
            throw new Exception('Rest call return http error:'.$response->statusCode);
        }
        if ($this->_format !== null) {
            $response->setFormat($this->_format);
        }
        $data = $response->getData();
        if(is_array($data) && isset($data['result']) && $data['result'] === 'error'){
            throw new Exception(sprintf('Rest call error: %s', $data['message']));
        }
        return $data;
    }

    protected function _prepareParams($params) {
        if ($this->_vendoProtectionSecret && !is_string($params)) {
            $parts = parse_url($this->_url);
            $uri = $parts['path'] . '?'. \http_build_query($params);
            $params['signature'] = $this->_addVendoProtection($uri);
        }
        return $params;
    }

    protected function _addVendoProtection($url) {
        $key = $this->_vendoProtectionSecret;

        // SHA-1 blocksize = 512 bits = 64 * 8

        if (strlen($key) > 64) {
            $key = sha1($key, true);
        } else {
            $key = str_pad($key, 64, chr(0));
        }

        $ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

        $hash = sha1($opad . sha1($ipad . $url, true), true);
        $hash = $this->_base64UrlEncode($hash);

        return $hash;
    }

    protected function _base64UrlEncode($data) {
        $data = base64_encode($data);

        $data = str_replace('=', '', $data);
        $data = str_replace('+', '-', $data);
        $data = str_replace('/', '_', $data);

        return $data;
    }


    public function disableSSLVerifyPeer() {
        $this->_sslVerifyPeerDisabled = true;
    }

    /**
     * @param int $maxTimeLimit
     * @return $this
     */
    public function setMaxTimeLimit(int $maxTimeLimit) {
        $this->_maxTimeLimit = $maxTimeLimit;
        return $this;
    }
}