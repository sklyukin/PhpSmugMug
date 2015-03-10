<?php
namespace sklyukin\PhpSmugMug;

class SmugMug
{
    public $apiKey;
    /** @var integer Set timeout default. */
    public $timeout = 30;
    /** @var integer Set connect timeout */
    public $connectTimeout = 30;
    /** @var boolean Verify SSL Cert */
    public $sslVerifyPeer = false;

    /** @var integer Contains the last HTTP status code returned */
    public $httpCode = 0;

    /** @var array Contains the last Server headers returned */
    public $httpHeader = [];
    /** @var array Contains the last HTTP headers returned */
    public $httpInfo = [];

    /** @var boolean Throw cURL errors */
    public $throwCurlErrors = true;

    /** @var string Set the useragent */
    private $userAgent = 'PHP SmugMug';

    const API_URL = 'http://api.smugmug.com/api/v2/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function albums($username, $count = 50, $start = 0)
    {
        return $this->request('user/' . $username . '!albums', ['count' => $count, 'start' => $start]);
    }


    private function request($uri, $params, $method = 'GET', $postFields = null)
    {
        $url = self::API_URL . $uri . $this->buildQueryString(array_merge($params, ['APIKey' => $this->apiKey]));
        $this->httpInfo = [];
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($crl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Host: fishska.com']);
        curl_setopt($crl, CURLOPT_HEADERFUNCTION, [$this, 'getHeader']);
        curl_setopt($crl, CURLOPT_HEADER, false);
        curl_setopt($crl, CURLOPT_URL, $url);
        $response = curl_exec($crl);
        $this->httpCode = curl_getinfo($crl, CURLINFO_HTTP_CODE);
        $this->httpInfo = array_merge($this->httpInfo, curl_getinfo($crl));
        if (curl_errno($crl) && $this->throwCurlErrors === true) {
            throw new SmugMugException(curl_error($crl), curl_errno($crl));
        }
        curl_close($crl);
        return json_decode($response, true)['Response'];
    }

    /**
     * Get the header info to store
     */
    private function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->httpHeader[$key] = $value;
        }
        return strlen($header);
    }

    /**
     * Build query string
     * @param   array
     * @return  string
     */
    private function buildQueryString($params)
    {
        $param = [];
        $query_string = null;
        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $param[$key] = $value;
            }
        }
        if (!empty($param)) {
            $query_string = '?' . http_build_query($param);
        }
        return $query_string;
    }
}