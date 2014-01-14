<?php
namespace www\www\render\html;

trait trait_tpl{

	protected static $TPL_DIR;
	protected static $TPL_EXT 			= '.html';

	private $tpl_vars 					= array();
	private $tpl_content;
	private $params;

	public $val 						= array();
	private $tpl_out 					= '';

	protected $tpl_base_dir;

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

		tpl::$tpl_dir 	= dirname(__FILE__);
		tpl::$tpl_env 	= $this->tpl_env;
		tpl::$tpl_render= $this->tpl_render;
		tpl::$tpl_theme = $this->tpl_theme;
		tpl::$tpl_page 	= $this->tpl_page;
		tpl::$tpl_lang 	= $this->tpl_lang;
		$var 			= new tpl($this->tpl);

		$var->load($this->tpl);
		$var->compile();

		if($this->tpl_out === '') $this->tpl_out = $var->val;
echo $var->val;
		return $var->val;
	}
	public function tpl_out($out = false){

		if($out === false) $out === $this->tpl_out;

		echo $out;
	}
}

?>