<?php
namespace html;

class img extends html {

	CONST ID_BASE 	= 'img_';
	CONST DIR 		= 'img';

	private $dir;
	private $file;

	public function txt_load($val){

		$this->dir 	= $this->tpl_dir.DIRECTORY_SEPARATOR.self::DIR;
		$val 		= explode(self::$TPL_VAR_SEPARATOR_VAL_LIST, $val);
		$file 		= $val[0];
		$title 		= $val[1];
		$this->file = glob($this->dir.DIRECTORY_SEPARATOR.$file.'*')[0];
		$this->val 	= '
<img
	id="'.self::$img_id_base.'_'.$this->id.'"
	src="'.$val.'"
	type="text/img"
	title="'.$title.'"
/>'."\n";

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>