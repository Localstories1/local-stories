<?php

date_default_timezone_set('Europe/Paris');
ini_set('display_errors', 'On');
error_reporting(E_ALL-E_STRICT);
ini_set('memory_limit','1000M');
set_time_limit(0);

trait render_html_img{

	private $render_html_img_id 	= 'png';
	private $render_html_img_ext 	= '.png';
	private $render_html_img_dir 	= 'img';
	private $render_html_img_tag 	= 'STATIC_IMG';
	private $render_html_img_var 	= 'IMG_REQUIRE=';

	private function render_html_img_static_clean($params = array()){

		$content 	= $params['content'];
		$base_dir 	= $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir;
		$base_dir 	= $base_dir.DIRECTORY_SEPARATOR.$this->render_html_img_dir;

		if(isset($this->render_vars[$this->render_html_img_tag]) === false) $this->render_var_add($this->render_html_img_tag, array());

		foreach($content as $k => $v){

			if(strstr($v, $this->render_html_img_var) === false) continue;

			$v 												 				= str_replace($this->render_html_img_var, '', $v);
			$v 												 				= trim($v);

			$script															= $base_dir.DIRECTORY_SEPARATOR.$v.$this->render_html_img_ext;
			$script											 				= str_replace(DIRECTORY_SEPARATOR, '/', $script);
			$this->render_vars[$this->render_html_img_tag][strtoupper($v)] 	= '<img id="'.$this->render_html_img_tag.'_'.strtoupper($v).'" src="'.$script.'" type="text/img" title="{'.$this->render_html_img_var.'_TITLE}" />'."\n";

			unset($content[$k]);
		}
		return $content;
	}
	private function render_html_img_share($params = array()){

		$tpl = $params['tpl'];

		foreach($tpl->render_vars[$this->render_html_img_tag] as $v => $html){

			$tag 						= $this->render_html_img_tag.'_'.$v;
			$this->render_vars[$tag] 	= trim($html);
		}
		return $tpl;
	}
}

?>