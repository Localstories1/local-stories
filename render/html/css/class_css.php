<?php
namespace www\www\render\html;

class css extends \www\www\render\html {

	CONST ID_BASE 	= 'css_';
	CONST DIR 		= 'css';
	CONST EXT 		= '.css';

	public function load($val){

		$this->dir 			= $this->resouce_dir.DIRECTORY_SEPARATOR.self::DIR;
		$this->file 		= $this->dir.DIRECTORY_SEPARATOR.$val.self::EXT;
		$class 				= '\\page';
		$this->url 			= $class::file_to_url($this->file);
		$this->val[$val] 	= '<link rel="stylesheet" href="'.$this->url.'" type="text/css">'."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$this->val = implode("\n", $this->val);

		return true;
	}
}

?>