<?php
namespace www\www\render\html;

class js extends \www\www\render\html {

	CONST ID_BASE 	= 'js_';
	CONST DIR 		= 'js';
	CONST EXT 		= '.js';

	public function load($val){

		$this->dir 			= $this->resouce_dir.DIRECTORY_SEPARATOR.self::DIR;
		$this->file 		= $this->dir.DIRECTORY_SEPARATOR.$val.self::EXT;
		$class 				= '\\page';
		$this->url 			= $class::file_to_url($this->file);
		$this->val[$val] 	= '<script href="'.$this->url.'" type="text/javascript"></script>'."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$this->val = implode("\n", $this->val);

		return true;
	}
}

?>