<?php

namespace sergios\yii2Worksection\src\mappers;

use sergios\yii2Worksection\src\adapters\CommentAdapter;
use sergios\yii2Worksection\src\models\Comment;
use sergios\yii2Worksection\src\models\interfaces\ModelInterface;
use sergios\yii2Worksection\src\models\Model;
use sergios\yii2Worksection\src\validators\WSApiValidator;
use sergios\yii2Worksection\src\WSApi;
use sergios\yii2Worksection\src\WSApiCriteria;
use yii\helpers\VarDumper;

class CommentMapper extends Mapper
{

    protected $action = 'get_comments';

    //TODO remove all this params
    public function __construct(String $apiAction, String $projectId, String $taskId = '')
    {
        parent::__construct();

        $this->wsApi->setAction($apiAction);
        $this->wsApi->setProjectId($projectId);
        $this->wsApi->setTaskId($taskId);

        $this->adapter = new CommentAdapter();
    }


    public function findByUserEmail()
    {
        $this->adapter->toApi();
    }

    public function findByAttributes($comment)
    {
        $criteria = (new WSApiCriteria('get_comments'))
            ->setPage($comment->getPage())
            ->setParams(CommentAdapter::toApi($comment));

        $data = wsApi::getInstance()->get($criteria);
        if($data){
            return $this->createCollection($data);
        }

        return $data;
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function deleteByAttributes()
    {
        // TODO: Implement deleteByAttributes() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    protected function createModel()
    {
        // TODO: Implement createModel() method.
    }

    protected function createCollection()
    {
        // TODO: Implement createCollection() method.
    }
}