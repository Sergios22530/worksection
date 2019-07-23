<?php


namespace sergios\worksectionApi\src\services;


class WSRequestCriteria
{
    private $action;
    private $page;
    private $params = [];


    public function __construct(String $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param mixed $page
     * @return WSRequestCriteria
     */
    public function setPage($page)
    {
        $this->page = (!empty($page)) ? $page : '';
        return $this;
    }

    /**
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return String
     */
    public function getAction(): String
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return (!empty($this->params)) ? $this->params : [];
    }
}
