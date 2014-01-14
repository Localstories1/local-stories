<?php
namespace www\www;

trait trait_data{

	public static $data_replace 	= '_';
	public static $data_strtolower 	= true;
	public static $data_charset 	= 'utf-8';

	public static function data_suppr_accent(
			$str,
			$replace = false,
			$charset = false){

		if($replace === false) $replace = self::$data_replace;
		if($charset === false) $charset = self::$data_charset;

		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
		$str = preg_replace('#&[^;]+;#', '', $str);

		return $str;
	}
	public static function data_suppr_double(
				$str,
				$double = false,
				$charset = false){

		if($double 	=== false) 	$double 	= self::$data_replace;
		if($charset === false) 	$charset 	= self::$data_charset;

		while(strstr($str, $double.$double) !== false) $str = str_replace($double.$double, $double, $str);

		return $str;
	}
	public static function data_suppr_dirty(
				$str,
				$replace 	= false,
				$strtolower = true,
				$charset 	= false){

		if($replace 	=== false) 	$replace 	= self::$data_replace;
		if($strtolower 	=== false)	$strtolower = self::$data_strtolower;
		if($charset 	=== false) 	$charset 	= self::$data_charset;

		$str = self::data_suppr_accent($str, $replace);
		$str = self::data_suppr_double($str, $replace);

		if($strtolower === true) $str = strtolower($str);

		return $str;
	}
}

?>