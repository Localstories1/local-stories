<?php

trait render_html {

	use render_html_tmp;

	private $render_html_theme_tpl_ext = '.html';

	private function render_html_out($params = array()){

		if(isset($params['tpl']) 	=== true) 				$this->tpl 					= $params['tpl'];
		if(isset($params['theme']) 	=== true) 				$this->theme 				= $params['theme'];
		if(isset($params['render']) === true) 				$this->render 				= $params['render'];
		if(isset($params['render_vars']) === true) 			$this->render_vars 			= $params['render_vars'];
		if(isset($params['render_vars_locked']) === true) 	$this->render_vars_locked 	= $params['render_vars_locked'];

		echo $this->content_list[$this->render][$this->theme][$this->tpl];

		return true;
	}
	private function get_basedir(){

		return $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir;
	}
	private function get_statics(){

		$base_dir 	= $this->get_basedir();
		$statics 	= glob($base_dir.DIRECTORY_SEPARATOR.'*');

		foreach($statics as $k => $dir){

			if(is_file($dir) === true) {

				unset($statics[$k]);

				continue;
			}
			$statics[$k] = basename($dir);
		}
		return $statics;
	}
	private function render_html_load($params = array()){

		if(isset($params['tpl']) 	=== true) 				$this->tpl 					= $params['tpl'];
		if(isset($params['theme']) 	=== true) 				$this->theme 				= $params['theme'];
		if(isset($params['render']) === true) 				$this->render 				= $params['render'];
		if(isset($params['render_vars']) === true) 			$this->render_vars 			= $params['render_vars'];
		if(isset($params['render_vars_locked']) === true) 	$this->render_vars_locked 	= $params['render_vars_locked'];

		$base_dir 	= $this->get_basedir();
		$content 	= file_get_contents($base_dir.DIRECTORY_SEPARATOR.$this->tpl.$this->render_html_theme_tpl_ext);
		$content 	= explode("\n", $content);
		$content 	= $this->init($content);
		$statics 	= $this->get_statics();

		foreach($statics as $dir){

			$params['content'] 	= $content;
			$content 			= $this->render_handle_func($dir.'_static_clean', $params);
		}
		$content = implode("\n", $content);

		return $this->set_content($content);
	}
	private function render_html_share($param, $prototype = 'page'){

		$tpl_params['tpl'] 					= $param['tpl'];
		$tpl_params['theme'] 				= $this->theme;
		$tpl_params['render'] 				= $this->render;
		$tpl_params['render_vars'] 			= $this->render_vars;
		$tpl_params['render_vars_locked'] 	= $this->render_vars_locked;
		$tpl 								= new $prototype($tpl_params);
		$statics 							= $this->get_statics();

		$tpl->load($tpl_params);
		$tpl->remplace();

		foreach($statics as $dir){

			$params['tpl'] 	= $tpl;
			$tpl 			= $this->render_handle_func($dir.'_share', $params);
		}
		return $tpl;
	}
}

?>