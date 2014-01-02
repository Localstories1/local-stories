<?php

trait render_html_css{

	private $render_html_css_id 	= 'css';
	private $render_html_css_ext 	= '.css';
	private $render_html_css_dir 	= 'css';
	private $render_html_css_tag 	= 'STATIC_CSS';
	private $render_html_css_var 	= 'CSS_REQUIRE=';

	private function render_html_css_static_clean($params = array()){

		$content 	= $params['content'];
		$base_dir 	= $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir;
		$base_dir 	= $base_dir.DIRECTORY_SEPARATOR.$this->render_html_css_dir;

		if(isset($this->render_vars[$this->render_html_css_tag]) === false) $this->render_var_add($this->render_html_css_tag, '');

		foreach($content as $k => $v){

			if(strstr($v, $this->render_html_css_var) === false) continue;

			$v 			= str_replace($this->render_html_css_var, '', $v);
			$v 			= trim($v);
			$script		= $base_dir.DIRECTORY_SEPARATOR.$v.$this->render_html_css_ext;
			$script		= str_replace(DIRECTORY_SEPARATOR, '/', $script);
			$img_dir 	= $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir.DIRECTORY_SEPARATOR.$this->render_html_img_dir;
			$h 			= md5($img_dir);
			$copy 		= $base_dir.DIRECTORY_SEPARATOR.$h.$this->render_html_css_ext;

			$copy_cont  = file_get_contents($script);
			//$copy_cont  = str_replace('{IMG}', $img_dir, $copy_cont);
			$copy_cont  = str_replace('{IMG}', '../'.$this->render_html_img_dir, $copy_cont);

			file_put_contents($copy, $copy_cont);

			$copy											 = str_replace(DIRECTORY_SEPARATOR, '/', $copy);
			$this->render_vars[$this->render_html_css_tag] 	.= '<link rel="stylesheet" href="'.$copy.'" type="text/css">'."\n";

			unset($content[$k]);
		}
		return $content;
	}
	private function render_html_css_share($params = array()){

		$tpl 											= $params['tpl'];
		$this->render_vars[$this->render_html_css_tag]	= trim($this->render_vars[$this->render_html_css_tag]);
		$tpl->render_vars[$this->render_html_css_tag]	= trim($tpl->render_vars[$this->render_html_css_tag]);
		$tmp 											= explode("\n", $this->render_vars[$this->render_html_css_tag]);
		$tmp2 											= explode("\n", $tpl->render_vars[$this->render_html_css_tag]);
		$this->render_vars[$this->render_html_css_tag] 	= array_merge($tmp, $tmp2);
		$this->render_vars[$this->render_html_css_tag]	= array_unique($this->render_vars[$this->render_html_css_tag]);
		$this->render_vars[$this->render_html_css_tag] 	= implode("\n", $this->render_vars[$this->render_html_css_tag])."\n";

		return $tpl;
	}
}


?>