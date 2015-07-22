<?php

//http://***/examples.php?image=/image.jpg  // Processing relative path
//http://***/examples.php?image=http://***/image.jpg // Processing the absolute path
//http://***/image.jpg // Automatic processing through htaccess

$image = isset($_GET['image']) ? $_GET['image'] : '/image.jpg';

include 'src/WaterMask.php';

$watermask = new Visavi\Watermask($image, '/watermark.png');
$watermask->render();

