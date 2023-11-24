<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/head.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/header.php';
?>


<main>
    <div class="container">
        <div class="sections">
            <div class="cam-section">
                <form method="POST" enctype="multipart/form-data" action="/camera/add">
                    <div class="section">
                        <div class="section-title">
                            <h3>Подключить камеру по ip</h3>
                        </div>
                        <div class="section-body">
                            <input type="text" name="ip" class="findCam">
                            <button type="submit" class="submitStreamBtn">Подключиться</button>
                        </div>
                    </div>
                    <div class="section">
                        <div class="section-title">
                            <h3>Загрузить разметку</h3>
                        </div>
                        <div class="section-body">
                            <input type="file" name="conf" required hidden id="razmetka">
                            <label for="razmetka" class="label">загрузить разметку</label>
                        </div>
                    </div>
                </form>
                <div class="section">
                    <div class="section-title">
                        <h3>Подключённые камеры</h3>
                    </div>
                    <div class="section-body">
                        <div class="section-body" id="cams">
                            <?php foreach ($this->camera as $camera): ?>
                            <a href="/camera?id=<?=$camera['id']?>" class="stream">
                                Камера <?=$camera['camera']?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upload-section">

                <form method="POST" enctype="multipart/form-data" action="/uploadVideo">
                    <div class="section">
                        <div class="section-title">
                            <h3>Загрузить видео</h3>
                        </div>
                        <div class="section-body">
                            <input type="file" name="file" id="video" hidden>
                            <label for="video" class="label">загрузить разметку</label>
                            <br>
                            <input type="file" name="conf" id="conf" hidden>
                            <label for="conf" class="label">загрузить разметку</label>
                            <br>
                            <button type="submit" class="submitStreamBtn">Загрузить</button>
                        </div>
                    </div>
                </form>


                <div class="section">
                    <div class="section-title">Видео с камер</div>
                    <div class="section-body" id="videos">
                        <?php foreach ($this->videoData as $video): ?>
                            <a href="/video?id=<?=$video['id']?>" class="video">
                                Видео <?=$video['id']?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/footer.php';
?>
