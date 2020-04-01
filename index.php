<?php

error_reporting(-1);
ini_set('display_errors', '1');

require __DIR__ . '/src/autoload.php';

use classes\ImageFactory;
use classes\Image;

if (!empty($_FILES)) {

    //require $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'xhgui/external/header.php';

    //xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

    $uploadImage = $_FILES['image'];

    try {
        $img = ImageFactory::create($uploadImage);

        echo '<div>';

        if (!$img->saveImage()) echo 'Не удалось сохранить изображение';
        else echo 'Изображение загружено';

        echo '</div>';
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

    //$xhprof_data = xhprof_disable();
    //include_once "xhprof_lib/utils/xhprof_lib.php";
    //include_once "xhprof_lib/utils/xhprof_runs.php";
    //$xhprof_runs = new XHProfRuns_Default();
    //$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_test");
    //echo '<br />';
    //echo "Report: http://localhost/xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_test";
}

?>

<!DOCTYPE HTML>

<html>

<head>
    <meta charset="utf-8">

    <title>Загрузка изображений</title>

    <style type="text/css">
        div {
            margin-bottom: 15px;
        }
        p {
            margin: 0;
            padding: 0;
        }
        h4 {
            margin-bottom: 0;
        }
    </style>

</head>

<body>

<h4>Загрузка изображений</h4>

<div>
    <p>преобразование загруженного изображения в изображение с заданными размерами;
    <p>ширина изображения, требуемая для загрузки, более <?= Image::WIDTH_REQ ?>;
    <p>высота изображения, требуемая для загрузки, более <?= Image::HEIGHT_REQ ?>.
    <p>Допустимые типы изображений: <?= implode(', ', ImageFactory::IMAGE_TYPES) ?>.
</div>

<form action = "index.php" method = "POST" enctype = "multipart/form-data">

    <div>
        <input type="file" id="image" class="" name="image" aria-required="true">
    </div>

    <div>
        <button type="submit" class="btn btn-success">Отправить</button>
    </div>

</form>

</html>
