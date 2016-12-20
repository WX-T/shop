<?php
class ControllerToolCaptcha extends Controller {
	public function index() {
		//$this->session->data['captcha'] = substr(sha1(mt_rand()), 17, 6);
	    $this->session->data['captcha'] = $this->make_password();
	    
		$image = imagecreatetruecolor(80, 34);

		$width = imagesx($image);
		$height = imagesy($image);

		$black = imagecolorallocate($image, 0, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);
		$red = imagecolorallocatealpha($image, 255, 0, 0, 75);
		$green = imagecolorallocatealpha($image, 0, 255, 0, 75);
		$blue = imagecolorallocatealpha($image, 0, 0, 255, 75);

		imagefilledrectangle($image, 0, 0, $width, $height, $white);

		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $red);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $green);
		imagefilledellipse($image, ceil(rand(5, 145)), ceil(rand(0, 35)), 30, 30, $blue);

		imagefilledrectangle($image, 0, 0, $width, 0, $black);
		imagefilledrectangle($image, $width - 1, 0, $width - 1, $height - 1, $black);
		imagefilledrectangle($image, 0, 0, 0, $height - 1, $black);
		imagefilledrectangle($image, 0, $height - 1, $width, $height - 1, $black);

		imagestring($image, 10, intval(($width - (strlen($this->session->data['captcha']) * 9)) / 2), intval(($height - 15) / 2), $this->session->data['captcha'], $black);

		header('Content-type: image/jpeg');

		imagejpeg($image);

		imagedestroy($image);
	}
	
	
	private function make_password( $length = 4 )
	{
	    // 密码字符集，可任意添加你需要的字符
	    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length);
	    $password = '';
	    for($i = 0; $i < $length; $i++)
	    {
	        // 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];
	    }
	    return $password;
	}
}