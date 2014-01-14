<?php
namespace www\www\render\html;

class tpl extends \www\www\render\html {

	CONST ID_BASE 	= 'tpl_';
	CONST DIR 		= 'tpl';
	CONST EXT 		= '.html';

	public function load($val){

		$this->dir 	= $this->resouce_dir.DIRECTORY_SEPARATOR.self::DIR;
		$val 		= $this->dir.'/'.$val.self::EXT;
		$this->val 	= file_get_contents($val);

		return $this->val;
	}
	public function compile(){

		if(is_array($this->val) === true) $this->val = implode("\n", $this->val);

		preg_match_all(self::TPL_VAR_SUB, $this->val, $m);

		$m = array_unique($m[1]);

		foreach($m as $k => $v){

			foreach($this->vars as $var){

				if($v !== $var->tag) continue;

				$this->val = str_replace($v, $var->val, $this->val);
			}
		}
		return $this->val;
	}
}

?>