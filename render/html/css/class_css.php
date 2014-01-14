<?php
namespace www\www\render\html;

class css extends \www\www\render\html {

	CONST ID_BASE 	= 'css_';
	CONST DIR 		= 'css';
	CONST EXT 		= '.css';

	private $dir;
	private $file;

	public function txt_load($val){

		$this->dir 	= $this->tpl_dir.DIRECTORY_SEPARATOR.self::DIR;
		$this->file = $this->dir.DIRECTORY_SEPARATOR.$val.self::EXT;
		$this->val 	= '<link rel="stylesheet" href="'.$this->file.'" type="text/css">'."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>