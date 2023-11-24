<?php

namespace engine\main\controllers;

use engine\base\controllers\BaseController;
use engine\main\models\MainModel;

class CameraController extends BaseController
{
    public $camera;

    private $_format = ['json'];


    public function index()
    {
        $id = $_GET['id'];
        if(!$this->model) $this->model = MainModel::getInstance();
        $this->camera = $this->model->read('camera', [
            'where' => ['id' => $id]
        ]);
    }

    public function addCamera()
    {
        if (empty($_FILES['conf']['name'])) {
            http_response_code(400);
            //echo "Не подходящий формат файла";
            $this->redirect('/');
        }

        $ext = pathinfo($_FILES['conf']['name'], PATHINFO_EXTENSION);
        if (!in_array($ext, $this->_format)) {
            http_response_code(400);
            //echo "Не подходящий формат файла";
            $this->redirect('/');
        }

        if(!$this->model) $this->model = MainModel::getInstance();
        $id = $this->model->read('upload_video', [
            'fields' => ['id'],
            'limit' => '1',
            'order' => ['id'],
            'order_direction' => ['DESC'],
        ]);

        if (!empty($id)) {
            $idNewVideo = $id[0]['id'];
        } else {
            $idNewVideo = 0;
        }

        $fileName = 'test_' . random_int(1, 1000000) . '.' . $ext;
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/files/uploads_camera_json/" . $fileName;

        if (move_uploaded_file($_FILES['conf']["tmp_name"], $targetPath)) {
            $this->model->add('camera', [
                'fields' => [
                    'json' => $fileName,
                    'camera' => $_REQUEST['ip']
                ]
            ]);


            http_response_code(200);
            $result = [
                "id" => $idNewVideo + 1,
                "status" => 'success'
            ];
            echo json_encode($result);

            $curl = curl_init();
            $aPost = array(
                'upload_id' => $idNewVideo + 1,
            );
            if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
                $aPost['file'] = new \CURLFile($targetPath);
                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            } else {
                $aPost['file'] = "@".$targetPath;
            }
            //curl_setopt($curl, CURLOPT_URL, $SITE_URL . 'loadVideo/test');
            curl_setopt($curl, CURLOPT_URL, "{$_ENV['BACKEND_API_URL']}/api/upload_file");
            curl_setopt($curl, CURLOPT_TIMEOUT, 120);
            curl_setopt($curl, CURLOPT_BUFFERSIZE, 128);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $aPost);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
            $sResponse = curl_exec($curl);

            // Получаем url и записываев в БД
            $this->model->update('camera', [
                'camera' => [
                    'camera_href' => 1,
                ],
                'where' => ['id' => $idNewVideo + 1]
            ]);
            // Редирект


            exit();
        } else {
            http_response_code(500);
            echo "Error";
            exit();
        }


        exit();
    }

    /**
     * @return false|string
     * @throws \engine\base\exceptions\RouteException
     */
    public function outputData()
    {
        return $this->render($_SERVER['DOCUMENT_ROOT'] . '/engine/main/views/cam');
    }

}