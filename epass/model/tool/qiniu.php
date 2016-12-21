<?php
/**
 * 七牛存储文件上传、所有后台图片都发送到七牛
 * @author: binzhao
 * @createTime: 2015-11-18
 */
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class ModelToolQiniu extends Model {
    
    //七牛验证key
    private $accessKey = 'SJDQvMAzIrd6FWhJTQbOA4-t7I2bxdfXX2DlPqUR';
    private $secretKey = 'eUsmlV12dpXw5fSbZ6Ijn-HJEmd4AOBF53wCjIQt';
    
	public function upload_image($filename) {
	    //验证auth
	    $auth = new Auth($this->accessKey, $this->secretKey);
	    //文件空间名
	    $bucket = 'legoods';
	    $token = $auth->uploadToken($bucket);
	    $uploadMgr = new UploadManager();
	    $filePath = $filename;
	    //上传后文件前缀
	    $pathArr = explode('image/', $filename);
	    $key = 'boc/image/'.end($pathArr);
	    //上传文件，成功返回true
	    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
        }else{
            return end($pathArr);
        }
	}
	
	public function delete_image($filename){
	    //验证auth
	    $auth = new Auth($this->accessKey, $this->secretKey);
	    //文件空间名
	    $bucket = 'legoods';
	    $token = $auth->uploadToken($bucket);
	    $delete = new BucketManager($auth);
	    $filePath = 'boc/image/'.$filename;
	    //上传后文件前缀
	    //$pathArr = explode('image/', $filename);
	    $key = 'boc/image/'.end($pathArr);
	    $delete->delete($bucket, $filePath);
	}
	
	/**
	 * 二进制上传图片到七牛返回地址
	 * @param unknown $filename
	 * @param unknown $data
	 */
	public function put($filename,$data){
	    //验证auth
	    $auth = new Auth($this->accessKey, $this->secretKey);
	    //文件空间名
	    $bucket = 'legoods';
	    $token = $auth->uploadToken($bucket);
	    $uploadMgr = new UploadManager();
	    $filePath = $filename;
	    //上传后文件前缀
	    $pathArr = explode('image/', $filename);
	    $key = 'boc/image/'.end($pathArr);
	    //上传文件，成功返回true
	    list($ret, $err)  = $uploadMgr->put($token, $key, $filePath);
	    if($err == null){
	        return  $ret['key'];
	    }
	}
}