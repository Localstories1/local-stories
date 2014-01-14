<?php
namespace www\www\render\html;

trait trait_tpl{

	private static $TPL_DIR;
	private static $TPL_EXT 			= '.html';

	private $tpl_vars 					= array();
	private $tpl_content;
	private $params;

	public $val 						= array();

	private $tpl_env 					= 'dev';
	private $tpl_render 				= 'html';
	private $tpl_theme 					= 'theme_default';
	private $tpl_tpl 					= 'base';
	private $tpl_page 					= 'index';
	private $tpl_lang 					= 'US';
	private $tpl_out 					= '';

	private $tpl_base_dir;

	public function __construct($params){

		self::$TPL_DIR  	= dirname(__FILE__);
		$this->params 		= $params;
		$this->tpl_lang 	= $params['lang'];
		$this->tpl 			= $params['tpl'];
		$this->val[0] 		= $this->tpl;
		$this->tpl_env		= $params['env'];
		$this->tpl_render	= $params['render'];
		$this->tpl_theme	= $params['theme'];
		$this->tpl_page		= $params['page'];
		$this->tpl_base_dir = self::$TPL_DIR;
	}
	public function tpl_load($val = false){

		if($val !== false) $this->tpl = $val;

		tpl::$tpl_dir 	= $this->tpl_base_dir;
		$var 			= new tpl($this->tpl);
		$val 			= $this->tpl_base_dir.DIRECTORY_SEPARATOR.$this->tpl.self::$TPL_EXT;

		$var->load($val);
		$var->compile();

		if($this->tpl_out === '') $this->out = $var->val;

		return $var->val;
	}
	public function tpl_out($out = false){

		if($out === false) $out === $this->tpl_out;

		echo $out;
	}
}

?>