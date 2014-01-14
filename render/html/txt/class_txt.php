<?php
namespace www\www\render\html;

class txt extends \www\www\render\html {

	public function load($val){

		$this->val = $val;

		return true;
	}
	public function compile(){

		if(is_string($this->val) === true) return true;

		$val = implode("\n", $this->val);

		return true;
	}
}

?>