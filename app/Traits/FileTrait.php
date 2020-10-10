<?php
namespace App\Traits;
use App;
use Image,File;

trait FileTrait {
	protected $path;
	protected $folderAndDimensions;
	protected $cropDimensions;
	protected $allowedExtToStream=['jpg','png','pdf','doc','docx'];
	
	/*
	@arg String
	@return FileTrait
	*/
	protected function setUploadPath($path){
		$this->path = $path;
		return $this;
	}
	
	/*
	@arg Array()
	** The setter for folder and dimension data : simple resize without x,y points
	@return FileTrait
	*/
	protected function setFolderAndDimensions($dimensions){
		
		if(!is_array($dimensions)) {
			die('Dimensions Must An Array');
		}
		
		$this->folderAndDimensions = $dimensions;
		
		return $this;
	}
	
	
	/*
	@arg Illuminate\Request , String
	** The method for simple file upload to $path
	@return Boolean/String
	*/
	protected function uploadFile($request,$controlName){
		try{
			
			if (!($this->path) || !$request->file($controlName) || !$request->file($controlName)->isValid()){
				return false;
			}
		
			$file = $request->file($controlName);
			$extension = $file->getClientOriginalExtension();
			$filename = md5(microtime()) . '.' . $extension;
			$uploadedFile = $request->file($controlName)->move($this->path, $filename);
			
			return $filename;
		
		}catch(\Exception $e){
		
			return false;
			
		}
		
	}
	
	
	/*
	@arg Illuminate\Request , String
	** The method to fit an Image for specified dimensions, using fit() method
	@return boolean/$string
	*/
	protected function fitImageToDimensions($request,$controlName){
		
		try{
			
			if(empty($this->folderAndDimensions)){
				return false;
			}
			
			$imageName = $this->uploadFile($request,$controlName);
			if(!$imageName){
				return false;
			}
			
			$sourceImage = $this->path. DIRECTORY_SEPARATOR .$imageName;
	
			foreach ($this->folderAndDimensions as $dimension) {
				if (!File::isDirectory($this->path .'/'.$dimension['folder'] . "/")) {
					File::makeDirectory($this->path .'/' .$dimension['folder']);
				}

				Image::make($sourceImage)
					->fit($dimension['width'], $dimension['height'])
					->save($this->path .'/'.$dimension['folder'].'/'.$imageName)
					->destroy();
			}
			
			return $imageName;
			
		}catch(\Exception $e){
			return false;
			
		}
		
	}
	
	
	/*
	@arg Illuminate\Request , String
	** The method for crop And resize an Image , for more accurate resize, using crop() & resize() methods
	@return boolean/$string
	*/
	protected function cropAndResizeImage($request,$controlName){
		
		try{
			$imageData = $request->input('image_crop_data');
			
			$imageName = $this->uploadFile($request,$controlName);
			
			if(!$imageName || empty($this->folderAndDimensions) || empty($imageData)){
				return false;
			}
			
			$sourceImage = $this->path. DIRECTORY_SEPARATOR .$imageName;

			foreach ($this->folderAndDimensions as $dimension) {
				if (!File::isDirectory($this->path .'/'.$dimension['folder'] . "/")) {
					File::makeDirectory($this->path .'/' .$dimension['folder']);
				}
			
				Image::make($sourceImage)
					->crop((int)$imageData['width'],(int)$imageData['height'],(int)$imageData['x'],(int)$imageData['y'])
					->resize($dimension['width'],$dimension['height'])
					->save($this->path .'/'.$dimension['folder'].'/'.$imageName);
			}
			return $imageName;
			
		}catch(\Exception $e){
		
			return false;
			
		}
		
	}
	
	protected function streamFile($path){
		
		if(File::exists($path)){
			$type = pathinfo($path, PATHINFO_EXTENSION);
			if(in_array($type,$this->allowedExtToStream)){
				$data = file_get_contents($path);
				$this->setStreamHeader($type);
				echo $data; 
			}
			
		}
		die;
		
	}
	
	private function setStreamHeader($type){
		
		switch($type){
			case 'pdf':
				header('Content-Type: application/octet-stream');
				header("Content-disposition: attachment;filename=file.pdf");
			break;
			
			default :
				header('Content-Type: image/jpeg');
			break;
		}
		
	}
	
	
}
?>