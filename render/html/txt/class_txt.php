<?php
namespace html;

class txt extends \render\render {

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