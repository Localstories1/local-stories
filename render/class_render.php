<?php
namespace www\www;

class render {

	public static $tpl_dir;
	public static $tpl_env 				= 'dev';
	public static $tpl_render 			= 'html';
	public static $tpl_theme 			= 'default';
	public static $tpl_tpl 				= 'base';
	public static $tpl_page 			= 'index';
	public static $tpl_lang 			= 'US';

	public $id;
	public $basename 					= '';
	public $type;
	public $var;
	public $lang;
	public $val 						= array();
	public $tag;
	public $tags 						= array();
	public $profils 					= array();
	public $compaigns    				= array();
	public $themes 						= array();
	public $locates    					= array();
	public $order;
	public $parent;
	public $index 						= false;
	public $desc_file					= false;
	public $vars 						= array();

	CONST VAR_PREFIX					= '';
	CONST TPL_EXT_DESC					= '.csv';
	CONST TPL_VAR_TAG 					= 'VAR:';
	CONST TPL_VAR_SUB 					= '#(\{[^\}]*\})#';
	CONST TPL_VAR_SEPARATOR_VAL 		= ';';
	CONST TPL_VAR_SEPARATOR_VAL_RPL 	= '--------------------------qfpj qsdfviopzjhfaqd51 3d0 d0azd----';
	CONST TPL_VAR_SEPARATOR_VAL_LIST 	= '|';

	public function __construct($basename = '', $v = false){

		if($v === false) $v = '{'.strtoupper($basename).'}';

		$this->basename = $basename;
		$this->id   	= \page::data_suppr_dirty($this->basename);
		$this->tag 		= $v;

		$this->load_desc();
	}
	public function load_desc(){

		$desc = self::$tpl_dir.DIRECTORY_SEPARATOR.$this->basename.self::TPL_EXT_DESC;

		if(is_file($desc) === false) return true;

		$this->desc_file 	= $desc;
		$tpl_vars 			= file_get_contents($desc);
		$tpl_vars 			= explode(self::TPL_VAR_TAG, $tpl_vars);

		foreach($tpl_vars as $k => $v){

			unset($tpl_vars[$k]);

			$v = trim($v);

			if(empty($v) === true) continue;

			$v = explode(self::TPL_VAR_SEPARATOR_VAL, $v);

			foreach($v as $i => $o) $v[$i] = str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL, $v[$i]);

			$lang = str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL, $v[2]);

			if(self::$tpl_lang !== $lang) continue;

			$type 				= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL, $v[3]);
			$class 				= '\\www\\www\\render\\html\\'.self::VAR_PREFIX.strtolower($type);
			$class::$tpl_dir 	= self::$tpl_dir;
			$class::$tpl_env 	= self::$tpl_env;
			$class::$tpl_render = self::$tpl_render;
			$class::$tpl_theme 	= self::$tpl_theme;
			$class::$tpl_tpl 	= self::$tpl_tpl;
			$class::$tpl_page 	= self::$tpl_page;
			$class::$tpl_lang 	= self::$tpl_lang;
			$var 				= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL, $v[1]);
			$tpl 				= new $class($var);
			$tpl->lang     	 	= $lang;
			$tpl->type      	= $type;
			$tpl->var 			= $var;
			$val 				= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL, $v[4]);
			$tpl->tags 			= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[5]));
			$tpl->profils 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[6]));
			$tpl->compaigns 	= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[7]));
			$tpl->themes 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[7]));
			$tpl->locates 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[8]));
			$tpl->order 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[9]);
			$tpl->parent 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[10]);
			$tpl->index 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[11]);
			$tpl->basename  	= $tpl->var;

			$tpl->load($val);

			$tpl_vars[$tpl->var] = $tpl;
		}
		foreach($tpl_vars as $var => $tpl){

			$this->vars[$var] = $tpl->compile();
		}
		return true;
	}
}

?>