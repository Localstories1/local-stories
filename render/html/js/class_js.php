<?php
namespace html;

class js extends html {

	CONST ID_BASE 	= 'js_';
	CONST DIR 		= 'js';
	CONST EXT 		= '.js';

	private $dir;
	private $file;

	public function txt_load($val){

		$this->dir 	= $this->tpl_dir.DIRECTORY_SEPARATOR.self::DIR;
		$this->file = $this->dir.DIRECTORY_SEPARATOR.$val.self::EXT;
		$this->val 	= '<link href="'.$this->file.'" type="text/javascript"></script>'."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>