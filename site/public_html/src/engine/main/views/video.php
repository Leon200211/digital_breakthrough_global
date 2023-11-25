<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/header.php';
?>
<main>
    <div class="container">
        <div class="sections">
            <div class="section">
                <div class="section-title">
                    <a href="<?="/files/uploads_video_result/" . $this->video[0]['result'];?>" class="video" onclick="return false;" download>Скачать файл</a>
                </div>
                <div class="section-body">
                    <img src="/templates/default/assets/img/1682702656_papik-pro-p-grafik-vniz-smail-png-27.png" alt="" width="600" height="360">
                </div>
            </div>
            <div class="section">
                <div class="section-title" style="text-align: right">
                    <h3>Видео №<?=$this->video[0]['id']?></h3>
                </div>
                <div class="section-body">
<!--                <iframe src="http://87.236.30.202:888/stream/" id="video-worker0"-->
<!--                        allowfullscreen="1" title="Home top" width="600" height="360" frameborder="0"></iframe>-->

                    <video width="500" height="300" controls>
                        <source src="/files/uploads_video/<?=$this->video[0]['video']?>" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
   

</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/footer.php';
?>
