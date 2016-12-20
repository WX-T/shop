<?php
/**
 * 七牛存储文件上传、所有后台图片都发送到七牛
 * @author: binzhao
 * @createTime: 2015-11-18
 */
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class ModelToolQiniu extends Model {
    
    //七牛验证key
    private $accessKey = 'oJxDK1s1p_Alq1EZHoraBOHe6uKPjhMkxL5jz9Sb';
    private $secretKey = 'a2rJEHW7Fq1GfNzgX_vLLB7H1KAOdS1UK1WatWZc';
    
	public function upload_image($filename) {
	    //验证auth
	    $auth = new Auth($this->accessKey, $this->secretKey);
	    //文件空间名
	    $bucket = 'slyc';
	    $token = $auth->uploadToken($bucket);
	    $uploadMgr = new UploadManager();
	    $filePath = $filename;
	    //上传后文件前缀
	    $pathArr = explode('image/', $filename);
	    $key = end($pathArr);
	    //上传文件，成功返回true
	    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
        }else{
            return true;
        }
	}
}