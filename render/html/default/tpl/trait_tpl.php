<?php

trait tpl{

	use render_tmp;

	public $tpl 					= 'base';
	public $theme 					= 'default';
	public $render 					= 'html';
	private $theme_dir 				= 'render';
	private $theme_tpl_dir 			= 'tpl';

	private $render_vars 			= array();
	private $render_vars_locked		= array();
	private $pattern 				= '#(\{[^\}]*\})#';
	private $content_last			= '';
	private $content_list			= array();
	private $render_var_add_tag		= 'render_var_add:';
	private $tpl_tag				= 'TPL:';
	private $static_tag				= 'STATIC_';

	public function __construct($params = array()){

		if(isset($params['tpl']) 	=== true) 				$this->tpl 					= $params['tpl'];
		if(isset($params['theme']) 	=== true) 				$this->theme 				= $params['theme'];
		if(isset($params['render']) === true) 				$this->render 				= $params['render'];
		if(isset($params['render_vars']) === true) 			$this->render_vars 			= $params['render_vars'];
		if(isset($params['render_vars_locked']) === true) 	$this->render_vars_locked 	= $params['render_vars_locked'];
	}
	private function render_handle_var($var){

		$var 					= 'render_'.$this->render.'_'.$var;
		$this->theme_tpl_ext 	= $this->$var;
	}
	private function render_handle_func($func, $params = array()){

		$func = 'render_'.$this->render.'_'.$func;

		return $this->$func($params);
	}
	private function set_content($content){

		$this->content_last 											= $content;
		$this->content_list[$this->render][$this->theme][$this->tpl] 	= $content;

		return $content;
	}
	private function init($content){

		foreach($content as $k => $v){

			if(strstr($v, $this->render_var_add_tag) === false) continue;

			$v = str_replace($this->render_var_add_tag, '', $v);
			$v = trim($v);
			$v = explode('=', $v);
			$v_bak = $v;
			unset($v_bak[0]);
			$v_bak = implode('=', $v_bak);
			$v[1] = $v_bak;
			if(strstr($v[1], '{') !== false && strstr($v[1], '}') !== false){

				foreach($this->render_vars as $k2 => $v2){

					if(is_array($v2) === true) continue;

					$v[1] = str_replace('{'.$k2.'}', $v2, $v[1]);
				}
			}
			if(isset($this->render_vars_locked[$v[0]]) !== true) $this->render_var_add($v[0], $v[1]);

			unset($content[$k]);
		}
		return $content;
	}
	public function load($params = array()){

		return $this->render_handle_func('load', $params);
	}
	public function render_var_add($k, $v){

		$this->render_vars[$k] = $v;

		return true;
	}
	public function remplace(){

		$content = $this->content_list[$this->render][$this->theme][$this->tpl];

		preg_match_all($this->pattern, $content, $m);

		$m = array_unique($m[1]);

		foreach($m as $k => $v){

			$var = str_replace('{', '', $v);
			$var = str_replace('}', '', $var);

			if(strstr($var, $this->tpl_tag) 	!== false) continue;
			if(strstr($var, $this->static_tag) 	!== false) continue;

			$content = str_replace($v, $this->render_vars[$var], $content);
		}
		preg_match_all($this->pattern, $content, $m);

		$m = array_unique($m[1]);

		foreach($m as $v){

			if(strstr($v, $this->tpl_tag) === false) continue;

			$var 			= str_replace('{'.$this->tpl_tag, '', $v);
			$var 		 	= str_replace('}', '', $var);
			$params['tpl'] 	= $var;
			$tpl 			= $this->render_handle_func('share', $params);

			$content = str_replace($v, $tpl->content_list[$this->render][$this->theme][$var], $content);
		}
		preg_match_all($this->pattern, $content, $m);

		$m = array_unique($m[1]);

		foreach($m as $k => $v){

			$var = str_replace('{', '', $v);
			$var = str_replace('}', '', $var);

			$content = str_replace($v, $this->render_vars[$var], $content);
		}
		$content = trim($content);

		return $this->set_content($content);
	}
	public function out($content = false){

		return $this->render_handle_func('out');
	}
}
?>