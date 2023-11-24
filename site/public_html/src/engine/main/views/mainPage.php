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
                <div class="section">
                    <div class="section-title">
                        <h3>Загрузить видео</h3>
                    </div>
                    <div class="section-body">
                        <a href="/video/upload" class="label" target="_blank">загрузить видео</a>
                    </div>
                </div>
                <div class="section">
                    <div class="section-title">Видео с камер</div>
                    <div class="section-body" id="videos">
                        <a href="video.html" class="video" data-process="1">
                            video123
                        </a>
                        <a href="video.html" class="video" data-process="0">
                            video123
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/default/include/footer.php';
?>
