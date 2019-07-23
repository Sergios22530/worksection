<?php

namespace sergios\worksectionApi\src\services;

use Exception;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\Request;
use Yii;

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
     * @param WSRequestCriteria $criteria
     * @return bool | array
     */
    public function get(WSRequestCriteria $criteria)
    {
        return $this->send($criteria, self::GET_METHOD);
    }

    /**
     * Set request parameters before sending request
     * @param WSRequestCriteria $criteria
     * @return bool | array
     */
    public function post(WSRequestCriteria $criteria)
    {
        return $this->send($criteria, self::POST_METHOD);
    }

    /**
     * Set request parameters before sending request
     * @param WSRequestCriteria $criteria
     * @param String $method
     * @return bool | array
     */
    private function send(WSRequestCriteria $criteria, String $method)
    {
        $url = $this->generateApiUrl($criteria);

        /** @var $response Request */
        $response = $this->httpClient->createRequest();
        if ($method == self::GET_METHOD) {
            $response->setFormat(Client::FORMAT_JSON);
        }
        $response->setMethod($method)
            ->setUrl($url)
            ->addData($criteria->getParams());
        $response = $response->send();

        return ($response->getData()['status'] == self::SUCCESS_ANSWER) ? $response->getData() : false;
    }

    /**
     * Generate api request url with http request params
     * @param WSRequestCriteria $criteria
     * @return String full url with action and hash params
     */
    public function generateApiUrl(WSRequestCriteria $criteria): String
    {
        $page = $criteria->getPage();
        $url = "https://doris.worksection.com/api/admin/?action={$criteria->getAction()}";
        $hash = $this->generateHash($criteria->getAction(), $page);
        $page = ($page) ? "&page={$page}" : '';

        return $url . $page . "&hash={$hash}";
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
        $this->setApiConfig();
    }

    /**
     * @throws Exception
     */
    private function setApiConfig()
    {
        try {
            $this->apiDomain = Yii::$app->params['worksection-api']['domain'];
            $this->apiKey = Yii::$app->params['worksection-api']['apiKey'];

        } catch (Exception $e) {
            throw new Exception('Set global params for api! (\'worksection-api\' => [\'domain\' => apiDomain, \'apiKey\' => key])');
        }
    }

    /**
     * @return mixed
     */
    public function getApiDomain()
    {
        return $this->apiDomain;
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
