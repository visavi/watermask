# Overlay grid watermarks

[![Latest Stable Version](https://poser.pugx.org/visavi/watermask/v/stable)](https://packagist.org/packages/visavi/watermask)
[![Total Downloads](https://poser.pugx.org/visavi/watermask/downloads)](https://packagist.org/packages/visavi/watermask)
[![Latest Unstable Version](https://poser.pugx.org/visavi/watermask/v/unstable)](https://packagist.org/packages/visavi/watermask)
[![License](https://poser.pugx.org/visavi/watermask/license)](https://packagist.org/packages/visavi/watermask)

Basic useful feature list:

 * It covers the entire image watermarks
 * Image processing gif, jpeg, jpg, png formats
 * Working with images from the relative and absolute paths
 * Checking the existence of the file, including remote file
 * Calculation of the aspect ratio of the watermark to the original image
 * Ability to customize the automatic imposition through .htaccess

```php
<FilesMatch ".(gif|jpg|jpeg|png)$">

  RewriteEngine on
  RewriteRule .*  /example.php?image=%{REQUEST_URI} [NC]

</FilesMatch>
```

###Examples of implementation of requests
```php
http://site/examples.php?image=/image.jpg  // Processing relative path
http://site/examples.php?image=http://site/image.jpg // Processing the absolute path
http://site/image.jpg // Automatic processing through htaccess
```

###Result
![Result](https://github.com/visavi/watermask/blob/master/result.jpg)

### Installing
```
composer require visavi/watermask
```

### License

The class is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
