<?php
namespace www\www\render;

trait trait_html {

	use \www\www\render\html\trait_html_tmp;

	public static function file_to_url($file, $dns = false){

		if($dns === false){

			$dns = $_SERVER['HTTP_HOST'];
		}
		$file = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
		$file = str_replace(DIRECTORY_SEPARATOR, '/', $file);
		$file = $dns.'/'.$file;

		while(strstr($file, '//') !== false) $file = str_replace('//', '/', $file);

		$file = 'http://'.$file;

		return $file;
	}
}
?>
