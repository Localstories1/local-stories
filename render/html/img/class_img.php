<?php
namespace www\www\render\html;

class img extends \www\www\render\html {

	CONST ID_BASE 	= 'img_';
	CONST DIR 		= 'img';
	CONST VAR_URL 	= '{DESIGN_IMG}';

	public function load($val){

		$this->dir 	= $this->resouce_dir.DIRECTORY_SEPARATOR.self::DIR;
		$val 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, $val);
		$file 		= $val[0];
		$title 		= $val[1];
		$this->file = glob($this->dir.DIRECTORY_SEPARATOR.$file.'*')[0];
		$class 		= '\\page';
		$this->url 	= $class::file_to_url($this->file);

		$this->val 	= '
<img
	id="'.self::ID_BASE.'_'.$this->id.'"
	src="'.$this->url.'"
	type="text/img"
	title="'.$this->url.'"
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