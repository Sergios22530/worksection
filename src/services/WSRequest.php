<?php

namespace sergios\worksectionApi\src;

use yii\httpclient\Client;
use yii\httpclient\Request;

/**
 * Class WSApi
 * @package sergios\worksectionApi\src
 *
 * @property Client $httpClient
 */
final class WSRequest
{
    protected $apiKey;
    protected $apiDomain;

    private $httpClient = null;

    private static $instance;

    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';

    const SUCCESS_ANSWER = 'ok';
    const ERROR_ANSWER = 'error';

    /**
     * gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance(): WSRequest
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * Set request parameters before sending request
     * @param WSApiCriteria $criteria
     * @return bool | array
     */
    public function get(WSApiCriteria $criteria)
    {
        return $this->send($criteria, self::GET_METHOD);
    }

    /**
     * Set request parameters before sending request
     * @param WSApiCriteria $criteria
     * @return bool | array
     */
    public function post(WSApiCriteria $criteria)
    {
        return $this->send($criteria, self::POST_METHOD);
    }

    /**
     * Set request parameters before sending request
     * @param WSApiCriteria $criteria
     * @param String $method
     * @return bool | array
     */
    private function send(WSApiCriteria $criteria, String $method)
    {
        $url = $this->generateApiUrl($criteria);

        /**
         * @var $response Request
         */
        $response = $this->httpClient->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod($method)
            ->setUrl($url)
            ->setData($criteria->getParams())
            ->send();

        return ($response->getData()['status'] == self::SUCCESS_ANSWER) ? $response->getData() : false;
    }

    /**
     * Generate api request url with http request params
     * @param WSApiCriteria $criteria
     * @return String full url with action and hash params
     */
    public function generateApiUrl(WSApiCriteria $criteria): String
    {
        $url = "https://doris.worksection.com/api/admin/?action={$criteria->getAction()}";
        $hash = $this->generateHash($criteria->getAction(), $criteria->getPage());
        return $url."&hash={$hash}";
    }

    /**
     * Generate Api hash
     * @param String $page
     * @param String $action
     * @return string
     */
    protected function generateHash(String $action, String $page): String
    {
        return md5($page . $action . $this->apiKey);
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }

}
