<?php
namespace www\www\render\html;

class url extends \www\www\render\html {

	public function load($val){

		$val = explode(self::TPL_VAR_SEPARATOR_VAL_LIST, $val);

		$type 				= $val[0];
		$class 				= '\\www\\www\\render\\html\\'.self::VAR_PREFIX.strtolower($type);
		$class::$tpl_dir 	= self::$tpl_dir;
		$class::$tpl_env 	= self::$tpl_env;
		$class::$tpl_render = self::$tpl_render;
		$class::$tpl_theme 	= self::$tpl_theme;
		$class::$tpl_tpl 	= self::$tpl_tpl;
		$class::$tpl_page 	= self::$tpl_page;
		$class::$tpl_lang 	= self::$tpl_lang;
		$var 				= $val[1];
		$tpl 				= new $class($var);
		$tpl->lang     	 	= $class::$tpl_lang;
		$tpl->type      	= $type;
		$tpl->var 			= $var;

		$tpl->load($val[1].self::TPL_VAR_SEPARATOR_VAL_LIST);
		$tpl->compile();

		$this->val 			= $tpl->url;

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>