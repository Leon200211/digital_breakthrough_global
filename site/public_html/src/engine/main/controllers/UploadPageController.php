<?php

namespace engine\main\controllers;

use engine\base\controllers\BaseController;
use engine\main\models\MainModel;

class UploadPageController extends BaseController
{

    private $_format = ['mp4', 'mov', 'wmv', 'avi', 'avchd', 'flv', 'f4v', 'swf', 'mkv', 'webm'];


    public function index()
    {

    }

    /**
     * @return false|string
     * @throws \engine\base\exceptions\RouteException
     */
    public function outputData()
    {
        return $this->render($_SERVER['DOCUMENT_ROOT'] . '/engine/main/views/upload_video');
    }

    public function uploadVideo(): void
    {

        if (empty($_FILES['file']['name'])) {
            http_response_code(400);
            //echo "Не подходящий формат файла";
            //exit();
            $this->redirect('/');
        }

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $ext_2 = pathinfo($_FILES['conf']['name'], PATHINFO_EXTENSION);
        if (!in_array($ext, $this->_format)) {
            http_response_code(400);
            //echo "Не подходящий формат файла";
            //exit();
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
        $targetPath = "/files/uploads_video/" . $fileName;

        $fileName_2 = 'test_' . random_int(1, 1000000) . '.' . $ext_2;
        $targetPath_2 = "/files/uploads_video_json/" . $fileName_2;

        if (move_uploaded_file($_FILES['file']["tmp_name"], $targetPath) && move_uploaded_file($_FILES['conf']["tmp_name"], $targetPath_2)) {
            $this->model->add('upload_video', [
                'fields' => [
                    'video' => $fileName,
                    'conf' => $fileName_2,
                    'is_processed' => 0
                ]
            ]);


            $curl = curl_init();
            $aPost = array(
                'upload_id' => $idNewVideo + 1,
            );
            $aPost['file'] = $targetPath;
            $aPost['conf'] = $targetPath_2;

//            if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
//                $aPost['file'] = new \CURLFile($targetPath);
//                $aPost['conf'] = new \CURLFile($targetPath_2);
//                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
//            } else {
//                $aPost['file'] = "@".$targetPath;
//                $aPost['conf'] = "@".$targetPath_2;
//            }

            //curl_setopt($curl, CURLOPT_URL, $SITE_URL . 'loadVideo/test');
            //curl_setopt($curl, CURLOPT_URL, "{$_ENV['BACKEND_API_URL']}/api/upload_file");
            curl_setopt($curl, CURLOPT_URL, "https://webhook.site/4d473d9e-0d57-4bd6-9826-e68b60cee06e");
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 120);
            curl_setopt($curl, CURLOPT_BUFFERSIZE, 128);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $aPost);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);
            $sResponse = curl_exec($curl);

            $this->redirect('/');

            exit();
        } else {
            http_response_code(500);
            echo "Error";
            exit();
        }
    }


    /**
     * @return void
     */
    public function uploadVideoFromApi(): void
    {

        $data = [
            'file' => $_FILES,
            'ruq' => $_REQUEST
        ];
        file_put_contents(__DIR__ . '/test2.log', print_r($data, 1), FILE_APPEND);



        if(!$this->model) $this->model = MainModel::getInstance();
        $videoDb = $this->model->read('upload_video', [
           'fields' => ['id', 'video'],
           'where' => ['id' => $_REQUEST['upload_id']]
        ]);
        if (empty($videoDb)) {
            http_response_code(400);
            echo "Не корректные данные";
            exit();
        }

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if (!in_array($ext, $this->_format)) {
            http_response_code(400);
            echo "Не подходящий формат файла";
            exit();
        }

        $fileName_2 = 'test_' . random_int(1, 1000000) . '.' . $ext;
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . "/files/uploads_video/" . $fileName_2;

        if (move_uploaded_file($_FILES['file']["tmp_name"], $targetPath)) {
            $this->model->update('upload_video', [
                'fields' => [
                    'video' => $fileName_2,
                    'is_processed' => 1,
                ],
                'where' => ['id' => $videoDb[0]['id']]
            ]);
            http_response_code(200);
            echo "success";
            exit();
        } else {
            http_response_code(500);
            echo "Error";
            exit();
        }

    }

    /**
     * @return void
     */
    public function checkVideo(): void
    {
        if (empty($_REQUEST['id'])) {
            http_response_code(400);
            echo "Error 400";
            exit();
        }

        if(!$this->model) $this->model = MainModel::getInstance();
        $videoDb = $this->model->read('upload_video', [
            'fields' => ['id', 'is_processed'],
            'where' => ['id' => $_REQUEST['id']]
        ]);

        if (empty($videoDb)) {
            http_response_code(400);
            echo "Не корректные данные";
            exit();
        }

        if ($videoDb[0]['is_processed'] == 1) {
            http_response_code(200);
            $result = [
                'is_processed' => 1,
            ];
            echo json_encode($result);
        } else {
            http_response_code(200);
            $result = [
                'is_processed' => 0
            ];
            echo json_encode($result);
        }
        session_write_close();
        exit();
    }

}