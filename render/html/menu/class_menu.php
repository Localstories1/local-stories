<?php
namespace www\www\render\html;

class menu extends \www\www\render\html {

	CONST ID_BASE 	= 'menu_';
	CONST DIR 		= 'menu';

	public function load($val){

		$this->dir 	= $this->resouce_dir.DIRECTORY_SEPARATOR.self::DIR;
		$class 		= 'h4';

		echo '<pre>';
		var_export($this->vars, true);
		echo '</pre>';

		foreach($this->vars as $var => $tpl){

			$list[$tpl->order] = $tpl;
		}
		ksort($list);

		foreach($list as $tpl){

			/*
			echo '<pre>';
			echo var_export($tpl, true);
			echo '</pre>';
			exit();
			*/
			if($this->index === 'true') $class = 'h3';

			$id 	= self::ID_BASE.$tpl->id;
			$link 	= 'index.php?page='.$this->id;

			$this->val[$tpl->parent][$tpl->order] = '
<li class="'.$class.'">
	<a href="'.$link.'" id="'.$id.'" name="'.$id.'">'.$tpl->val.'</a>
</li>
'."\n";
		}
		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return $this->val;

		$val = '';

		foreach($this->val as $parent => $links){

			ksort($links);

			$val .= '<nav><ul>'.implode("\n", $links).'</ul></nav>'."\n";
		}
		$this->val = $val;

		return true;
	}
}

?>