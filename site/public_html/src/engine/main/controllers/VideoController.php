<?php

namespace engine\main\controllers;

use engine\base\controllers\BaseController;
use engine\main\models\MainModel;

class VideoController extends BaseController
{
    public $video;

    public function index()
    {
        $id = $_GET['id'];
        if(!$this->model) $this->model = MainModel::getInstance();
        $this->video = $this->model->read('upload_video', [
            'where' => ['id' => $id]
        ]);



    }


    /**
     * @return false|string
     * @throws \engine\base\exceptions\RouteException
     */
    public function outputData()
    {
        return $this->render($_SERVER['DOCUMENT_ROOT'] . '/engine/main/views/video');
    }

}