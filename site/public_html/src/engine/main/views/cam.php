<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/header.php';
?>

<div class="container">
    <div class="sections">
        <div class="section">
            <div class="section-title">
                <h3>Скачать файл(тут файл с расчётами)</h3>
                <em>Файл был создан в 00:00:00</em>
            </div>
            <div class="section-body">
                <img src="assets/imgs/1682702656_papik-pro-p-grafik-vniz-smail-png-27.png" alt="" width="600" height="360">
            </div>
        </div>
        <div class="section">
            <div class="section-title" style="text-align: right">
                <h3>Камера/видео №123</h3>
            </div>
            <div class="section-body">
                <iframe src="http://87.236.30.202:888/stream/" id="stream-worker0"
                        allowfullscreen="1" title="Home top" width="600" height="360" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/footer.php';
?>
