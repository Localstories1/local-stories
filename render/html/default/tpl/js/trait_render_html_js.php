<?php

trait render_html_js{

	private $render_html_js_id 		= 'js';
	private $render_html_js_ext 	= '.js';
	private $render_html_js_dir 	= 'js';
	private $render_html_js_tag 	= 'STATIC_JS';
	private $render_html_js_var 	= 'JS_REQUIRE=';

	private function render_html_js_static_clean($params = array()){

		$content 	= $params['content'];
		$base_dir 	= $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir;
		$base_dir 	= $base_dir.DIRECTORY_SEPARATOR.$this->render_html_js_dir;

		if(isset($this->render_vars[$this->render_html_js_tag]) === false) $this->render_var_add($this->render_html_js_tag, '');

		foreach($content as $k => $v){

			if(strstr($v, $this->render_html_js_var) === false) continue;

			$v 												= str_replace($this->render_html_js_var, '', $v);
			$v 												= trim($v);
			$script											= $base_dir.DIRECTORY_SEPARATOR.$v.$this->render_html_js_ext;
			$script						 					= str_replace(DIRECTORY_SEPARATOR, '/', $script);
			$this->render_vars[$this->render_html_js_tag]  .= '<script src="'.$script.'" type="text/javascript"></script>'."\n";

			unset($content[$k]);
		}
		return $content;
	}
	private function render_html_js_share($params = array()){

		$tpl 											= $params['tpl'];
		$this->render_vars[$this->render_html_js_tag]	= trim($this->render_vars[$this->render_html_js_tag]);
		$tpl->render_vars[$this->render_html_js_tag]	= trim($tpl->render_vars[$this->render_html_js_tag]);
		$tmp 											= explode("\n", $this->render_vars[$this->render_html_js_tag]);
		$tmp2 											= explode("\n", $tpl->render_vars[$this->render_html_js_tag]);
		$this->render_vars[$this->render_html_js_tag] 	= array_merge($tmp, $tmp2);
		$this->render_vars[$this->render_html_js_tag]	= array_unique($this->render_vars[$this->render_html_js_tag]);
		$this->render_vars[$this->render_html_js_tag] 	= implode("\n", $this->render_vars[$this->render_html_js_tag])."\n";

		return $tpl;
	}
}

?>