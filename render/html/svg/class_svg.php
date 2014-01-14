<?php
namespace www\www\render\html;

class svg extends \www\www\render\html {

	CONST ID_BASE 	= 'svg_';
	CONST DIR 		= 'svg';
	CONST EXT 		= '.svg';

	private $dir;
	private $file;

	public function load($val){

		$this->dir 	= $this->tpl_dir.DIRECTORY_SEPARATOR.self::DIR;
		$this->file = $this->dir.DIRECTORY_SEPARATOR.$val.self::EXT;
		$this->val 	= file_get_contents($this->file)."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>