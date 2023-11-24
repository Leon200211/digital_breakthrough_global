<?php 


namespace engine\main\controllers;


use engine\base\exceptions\RouteException;
use engine\base\settings\Settings;
use engine\base\controllers\BaseController;
use engine\main\models\MainModel;


class MainPageController extends BaseController
{
    public $videoData = [];
    public $camera = [];

    public function index() : void 
    {
        if(!$this->model) $this->model = MainModel::getInstance();

        $camera = $this->model->read('camera');
        if (!empty($camera)) {
            $this->camera = $camera;
        } else {
            $this->camera = [];
        }

        $video = $this->model->read('upload_video');
        if (!empty($camera)) {
            $this->videoData = $video;
        } else {
            $this->videoData = [];
        }
    }

    public function outputData()
    {
        return $this->render($_SERVER['DOCUMENT_ROOT'] . '/engine/main/views/mainPage');
    }


}
