<?php

trait render_html_svg{

	private $render_html_svg_id 	= 'svg';
	private $render_html_svg_ext 	= '.svg';
	private $render_html_svg_dir 	= 'svg';
	private $render_html_svg_tag 	= 'STATIC_SVG';
	private $render_html_svg_var 	= 'SVG_REQUIRE=';

	private function render_html_svg_static_clean($params = array()){

		$content 	= $params['content'];
		$base_dir 	= $this->theme_dir.DIRECTORY_SEPARATOR.$this->render.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$this->theme_tpl_dir;
		$base_dir 	= $base_dir.DIRECTORY_SEPARATOR.$this->render_html_svg_dir;

		if(isset($this->render_vars[$this->render_html_svg_tag]) === false) $this->render_var_add($this->render_html_svg_tag, array());

		foreach($content as $k => $v){

			if(strstr($v, $this->render_html_svg_var) === false) continue;

			$v 												 				= str_replace($this->render_html_svg_var, '', $v);
			$v 												 				= trim($v);

			$script															= $base_dir.DIRECTORY_SEPARATOR.$v.$this->render_html_svg_ext;
			$script											 				= str_replace(DIRECTORY_SEPARATOR, '/', $script);
			$contentA 														= file_get_contents($script)."\n";
			$contentA 														= explode('dtd">', $contentA);
			unset($contentA[0]);
			$contentA 														= implode('dtd">', $contentA);
			$this->render_vars[$this->render_html_svg_tag][strtoupper($v)] 	= $contentA;

			unset($content[$k]);
		}
		return $content;
	}
	private function render_html_svg_share($params = array()){

		$tpl = $params['tpl'];

		foreach($tpl->render_vars[$this->render_html_svg_tag] as $v => $html){

			$tag 						= $this->render_html_svg_tag.'_'.$v;
			$this->render_vars[$tag] 	= trim($html);
		}
		return $tpl;
	}
}

?>