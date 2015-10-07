<?php


class Files{
	function get_line($file, $find){
		$file_contents = file_get_contents($file);
		return strpos($file_content, $find);
	}
	function ls($REQUEST, $target){
		$base = $target.$REQUEST->get("path", "/");
		$folders = scandir($base);
		$dir = array();
		foreach($folders as $directory){
			if($directory != '.' && $directory != '..'){
				if(is_dir($base.$directory)){
					$dir[$directory] = stat($base.$directory);
					$dir[$directory]["dir"] = true;
					$dir[$directory]["files"] = $this->ls($REQUEST, $base.$directory.'/');
				}else if(is_file($base.$directory)){
					$dir[$directory] = stat($base.$directory);
					$dir[$directory]["dir"] = false;
				}else if(is_link($base.$directory)){
					$dir[$directory] = lstat($base.$directory);
					$dir[$directory]["dir"] = false;
				}else{
					$dir[$directory] = null;
				}
					$dir[$directory]["path"] = $base.$directory;
					$dir[$directory]["relpath"] = substr($base, strpos($base, './')).$directory;
				if(substr($directory, 0,1) == '.'){
					$dir[$directory]["hidden"] = true;	
				}
			}
		}
		return $dir;
	}
	function makedir($REQUEST, $target){
		$path = $target.$REQUEST->get("path");	
		$OUTPUT = new Output();
		if(!mkdir($path, 0777, true)){
			$OUTPUT->error(1, "Failed to create directory");
		}else{
			$OUTPUT->success(1, stat($base.$path));
		}
	}
	function cp($REQUEST, $target){
		$path_old = $REQUEST->get("path_old");	
		$path_new = $target.$REQUEST->get("path_new", $path_old);	
		$path_old = $target.$path_old;	
		$name_old = $REQUEST->get("name_old");	
		$name_new = $REQUEST->get("name_new", $name_old);	
		$OUTPUT = new Output();
		if(!copy($path_old.$name_old, $path_new.$name_new)){
			$OUTPUT->error(1, "Failed to create a copy");
		}else{
			$OUTPUT->success(1, stat($new));
		}
	}
	function mv($REQUEST, $target){
		$path_old = $REQUEST->get("path_old");	
		$path_new = $target.$REQUEST->get("path_new", $path_old);
		$path_old = $target.$path_old;	
		$name_old = $REQUEST->get("name_old");	
		$name_new = $REQUEST->get("name_new", $name_old);	
		$OUTPUT = new Output();
		if(!rename($path_old.$name_old, $path_new.$name_new)){
			$OUTPUT->error(1, "Failed to move file or directory");
		}else{
			$OUTPUT->success(1, stat($new));
		}
	}
	function rm($REQUEST, $target){
		$path = $target.$REQUEST->get("path");	
		$name = $REQUEST->get("name");	
		$OUTPUT = new Output();
		if(!rename($old, "../removed/".$path.$name)){
			$OUTPUT->error(1, "Failed to remove file");
		}else{
			$OUTPUT->success(1, "Success");
		}

	}
	function upload($REQUEST, $target){
		$path = $target.$REQUEST->get("path", "/");
		$name = $REQUEST->get("name", "file");
		$file = $REQUEST->get("file");
		if(move_uploaded_file($file["tmp_name"], $path.$name)){
			$fileContent = file_get_contents($path.$name);
			$dataURL = 'data:' . $file["type"] . ';base64,' . base64_encode($fileContent);
			$ret = stat($path.$name);
			$ret["name"] = $name;
			$ret["path"] = $path;
			$ret["type"] = $file["type"];
			$ret["size"] = $file["size"];
			$ret["dataURL"] = $dataURL;
			$OUTPUT->success(0, $ret);
		}else{
			$OUTPUT->error(1, "File Upload was unsuccessful for unknown reasons");
		}
	}
}
?>
