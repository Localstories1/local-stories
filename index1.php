<?php

require_once '__init__.php';

class page{

	use trait_www;
}
$page = new page($params);
$page->tpl_load();
$page->tpl_out();

?>