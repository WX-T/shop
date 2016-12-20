<?php
class ModelToolImage extends Model {

    public function resize2($filename, $width = 0, $height = 0)
    {
        if($width && $height){
            return "http://7xoud2.com2.z0.glb.qiniucdn.com/" . $filename . "-" . $width . "x" . $height;
        }else{
            return "http://7xoud2.com2.z0.glb.qiniucdn.com/" . $filename;
        }
    }
    
	public function resize($filename, $width=0, $height=0) {
	    if(strstr($filename , 'http://')){
	        return $filename;
	    }
	    if(!$width || !$height){
	        if ($this->request->server['HTTPS']) {
	            //http://cdn.legoods.com/boc/shopyfashion/image/
	            //return $this->config->get('config_ssl') . 'image/' . $filename;
	            return 'http://cdn.legoods.com/boc/image/' . $filename;
	        } else {
	            //return $this->config->get('config_url') . 'image/' . $filename;
	            return 'http://cdn.legoods.com/boc/image/' . $filename;
	        }
	    }
	    
		/* if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}
 */
		/* $extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}
*/
		if ($this->request->server['HTTPS']) {
		    return 'http://cdn.legoods.com/boc/image/' . $filename;
			//return $this->config->get('config_ssl') . 'image/' . $new_image;
		} else {
		    return 'http://cdn.legoods.com/boc/image/' . $filename;
			//return $this->config->get('config_url') . 'image/' . $new_image;
		}
	}
	
}