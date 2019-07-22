<?php


namespace sergios\yii2Worksection\src;


class WSApiCriteria
{
    private $action;
    private $page;
    private $params;


    public function __construct(String $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param mixed $page
     * @return WSApiCriteria
     */
    public function setPage($page)
    {
        $this->page = $page||'';

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
        return $this->params||[];
    }
}