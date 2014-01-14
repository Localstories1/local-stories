<?php
namespace www\www;

abstract class render {

	public static $tpl_dir;
	public static $tpl_env;
	public static $tpl_render;
	public static $tpl_theme;
	public static $tpl_tpl;
	public static $tpl_page;
	public static $tpl_lang;

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
	public $resouce_dir;

	protected $dir;
	protected $file;

	CONST VAR_PREFIX					= '';
	CONST TPL_EXT_DESC					= '.csv';
	CONST TPL_VAR_TAG 					= 'VAR:';
	CONST TPL_VAR_SUB 					= '#(\{[^\}]*\})#';
	CONST TPL_VAR_SEPARATOR_VAL 		= ';';
	CONST TPL_VAR_SEPARATOR_VAL_RPL 	= '--------------------------qfpj qsdfviopzjhfaqd51 3d0 d0azd----';
	CONST TPL_VAR_SEPARATOR_VAL_LIST 	= '|';

	public function __construct($basename = '', $v = false){

		if($v === false) $v = '{'.strtoupper($basename).'}';

		$this->basename 	= $basename;
		$this->id   		= \page::data_suppr_dirty($this->basename);
		$this->tag 			= $v;
		$tmp 				= explode(DIRECTORY_SEPARATOR, self::$tpl_dir);
		$this->resouce_dir 	= str_replace(DIRECTORY_SEPARATOR.end($tmp), '', self::$tpl_dir);

		$this->load_desc();
	}
	public function load_desc(){

		$tmp 	= explode('\\', get_class($this));
		$dir 	= end($tmp);
		$desc 	= $this->resouce_dir.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$this->basename.self::TPL_EXT_DESC;

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
			$tpl->themes 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[8]));
			$tpl->locates 		= explode(self::TPL_VAR_SEPARATOR_VAL_LIST, str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[9]));
			$tpl->order 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[10]);
			$tpl->parent 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[11]);
			$tpl->index 		= str_replace(self::TPL_VAR_SEPARATOR_VAL_RPL, self::TPL_VAR_SEPARATOR_VAL_LIST, $v[12]);
			$tpl->basename  	= $tpl->var;

			$tpl->load($val);

			$tpl_vars[$tpl->var] = $tpl;
		}
		foreach($tpl_vars as $var => $tpl){

			$tpl->compile();
			$this->vars[$var] = $tpl;
		}
		return true;
	}
}

?>