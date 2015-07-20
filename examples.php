<?php
/*
<FilesMatch ".(gif|jpg|jpeg|png)$">

	RewriteEngine on
	RewriteRule .*  /include/image.php?image=%{REQUEST_URI} [NC]

</FilesMatch>
 */


include 'src/WaterMask.php';

$watermask = new Visavi\Watermask('image.jpg', 'watermark.png');
$watermask->render();
