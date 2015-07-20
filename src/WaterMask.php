<?php
/**
 * Overlay mesh watermark image
 * @license Code and contributions have MIT License
 * @link    http://visavi.net
 * @author  Alexander Grigorev <visavi.net@mail.ru>
 * @version 1.0
 */

namespace Visavi;

class Watermask {

	protected $filename;
	protected $watermark;
	protected $img = null;
	protected $water = null;

	protected static $imageTypes = ['jpeg', 'jpg', 'png', 'gif'];

	public function __construct($filename, $watermark)
	{
		if ($this->isLink($filename)) {
			$this->filename = $filename;
		} else {
			$this->filename = dirname(__DIR__).$filename;
		}

		$this->watermark =  dirname(__DIR__).$watermark;
	}

	/**
	 * Verify the existence of the file
	 * @return boolean result if a file exists
	 */
	public function exists()
	{
		if ($this->isLink($this->filename)) {
			return get_headers(urldecode($this->filename));
		} else {
			return is_file($this->filename) && file_exists($this->filename);
		}

	}

	public function isLink($filename)
	{
		return (preg_match('#^https?://#i', $filename) === 1);
	}

	/**
	 * Checking file
	 * @return boolean result of inspection
	 */
	public function validate()
	{
		$ext = strtolower(substr(strrchr($this->filename, '.'), 1));
		if (!in_array($ext, self::$imageTypes)) return false;

		if (!$this->exists()) return false;

		return true;
	}

	/**
	 * Imposing the mark
	 */
	public function render()
	{

		if (!$this->validate()) return false;

		$this->water = imagecreatefrompng($this->watermark);
		$water_width = imagesx($this->water);
		$water_height = imagesy($this->water);

		$image = getimagesize($this->filename);
		list($width, $height, $type, $attr) = $image;

		header('Content-Type: '.$image['mime']);
		header('Content-Disposition: inline; filename="'.basename($this->filename).'"');

		switch ($type) {
			// GIF
			case 1:
				$this->img = imagecreatefromgif($this->filename);
				$this->maskTransparent($this->img, $width, $height);
				$this->maskWatermark($this->img, $this->water, $width, $height, $water_width, $water_height);
				imagegif($this->img);
				break;

			// JPG
			case 2:
				$this->img = imagecreatefromjpeg($this->filename);
				$this->maskWatermark($this->img, $this->water, $width, $height, $water_width, $water_height);
				imagejpeg($this->img, null, 100);
				break;

			//PNG
			case 3:
				$this->img = imagecreatefrompng($this->filename);
				$this->maskWatermark($this->img, $this->water, $width, $height, $water_width, $water_height);
				imagepng($this->img);
				break;
			break;
		}
	}

	/**
	 * Наложение сетки водяных знаков
	 * @param  resource &$img         исходное изображение
	 * @param  resource &$water       водяной знак
	 * @param  integer  $width        ширина картинки
	 * @param  integer  $height       высота картинки
	 * @param  integer  $water_width  ширина знака
	 * @param  integer  $water_height высота знака
	 * @return resource
	 */
	protected function maskWatermark(&$img, &$water, $width, $height, $water_width, $water_height)
	{
		// Вычисление соотношения сторон водяного знака к исходному изображению
		$new_width = $new_height = round(($height > $width ? $width : $height) / 6);

		$new_water = imagecreatetruecolor($new_width, $new_height);
		imagecolortransparent($new_water, imagecolorallocatealpha($new_water, 0, 0, 0, 127));
		imagealphablending($new_water, false);
		imagesavealpha($new_water, true);

		imagecopyresampled($new_water, $water, 0, 0, 0, 0, $new_width, $new_height, $water_width, $water_height);


		$offset_x = $new_width * 2;
		$offset_y = $new_height;

		for ($x = 0; $x < $width; $x+=$offset_x){
			for ($y = 0, $s = 0; $s++, $y < $height; $y+=$offset_y){
				$shift = $s%2  ? 0 : $offset_y;
				imagecopy($img, $new_water, $x + $shift, $y, 0 , 0, $new_width, $new_height);
			}
		}
	}

	/**
	 * Создание новой картинки на основе прозрачного изображения, fix для GIF
	 * @param  resource &$resource изображение
	 * @param  integer $width      ширина
	 * @param  integer $height     высота
	 * @return boolean             результат
	 */
	protected function maskTransparent(&$resource, $width, $height)
	{
		// new canvas
		$canvas = imagecreatetruecolor($width, $height);
		// fill with transparent color
		imagealphablending($canvas, false);
		$transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
		imagefilledrectangle($canvas, 0, 0, $width, $height, $transparent);
		imagecolortransparent($canvas, $transparent);
		imagealphablending($canvas, true);
		// copy original
		imagecopy($canvas, $resource, 0, 0, 0, 0, $width, $height);
		imagedestroy($resource);
		$resource = $canvas;
		return true;
	}

	/**
	 * Удаление ресурсов
	 */
	public function __destruct()
	{
		if (is_resource($this->img)) {
			imagedestroy($this->img);
		}

		if (is_resource($this->water)) {
			imagedestroy($this->water);
		}
	}
}

$watermask = new Watermask($_GET['image'], '/include/watermark_new.png');
$watermask->render();
