<?php

date_default_timezone_set('Europe/Paris');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
ini_set('memory_limit','1000M');
set_time_limit(0);

$params['env']		= 'dev';
$params['render']	= 'html';
$params['theme']	= 'theme_default';
$params['tpl']		= 'base';
$params['page']		= 'index';
$params['lang']		= 'US';

class env{

  public function __construct($params){

    switch($params['env']){

      case 'dev':

        date_default_timezone_set('Europe/Paris');
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
        ini_set('memory_limit','1000M');
        set_time_limit(0);
        break;
    }
  }
}
new env($params);

trait trait_CONST_dir_trait{

  private static $TRAIT_PREFIX		= 'trait_';
  private static $TRAIT_EXT			= '.php';
  private static $TRAIT_TMP_SUFFIX	= '_tmp';

  public static function trait_build_load_all($dir, $parent = false){

    self::trait_build($dir, $parent);
    self::trait_build_tmp($dir, $parent);

    $base 			= basename($dir);
    $file_tmp 		= $dir.DIRECTORY_SEPARATOR.self::$TRAIT_PREFIX.$base.self::$TRAIT_TMP_SUFFIX.self::$TRAIT_EXT;
    $modules_dir 	= glob($dir.DIRECTORY_SEPARATOR.'*');

    foreach($modules_dir as $module_dir){

      if(is_dir($module_dir) === false) continue;

      if($parent === false) self::trait_build_load_all($module_dir, $base);
      else 					self::trait_build_load_all($module_dir, $parent.'\\'.$base);
    }
    require_once($file_tmp);

    $file = $dir.DIRECTORY_SEPARATOR.self::$TRAIT_PREFIX.$base.self::$TRAIT_EXT;

    require_once($file);

    $modules_dir = glob($dir.DIRECTORY_SEPARATOR.'*');
  }
  public static function trait_build($dir, $parent = false){

    $base 			= basename($dir);
    $file 			= $dir.DIRECTORY_SEPARATOR.self::$TRAIT_PREFIX.$base.self::$TRAIT_EXT;
    $file_tmp 		= $dir.DIRECTORY_SEPARATOR.self::$TRAIT_PREFIX.$base.self::$TRAIT_TMP_SUFFIX.self::$TRAIT_EXT;
   	$modules_dir 	= glob($dir.DIRECTORY_SEPARATOR.'*');

    if(is_file($file) === true) {

    	foreach($modules_dir as $module_dir){

    		if(is_dir($module_dir) === false) continue;

    		if($parent === false) 	self::trait_build($module_dir, $base);
    		else 					self::trait_build($module_dir, $parent.'\\'.$base);
    	}
    	return true;
    }
    if($parent === false) {

    	$parent 	= $base;
    	$use_path 	= $base;
    }
    else $use_path 	= $parent.'\\'.$base;

    $use 		= "\t".'use \\'.$use_path.'\\'.self::$TRAIT_PREFIX.$base.self::$TRAIT_TMP_SUFFIX.';'."\n";
    $content 	= '<?php
namespace '.$parent.';

trait '.self::$TRAIT_PREFIX.$base.' {

'.$use.'
}
?>
';
    file_put_contents($file, $content);
   	chmod($file, '0777');

    foreach($modules_dir as $module_dir){

      if(is_dir($module_dir) === false) continue;

      if($parent === false) self::trait_build($module_dir, $base);
      else 					self::trait_build($module_dir, $parent.'\\'.$base);
    }
    return true;
  }
  public static function trait_build_tmp($dir, $parent = false){

    $base 			= basename($dir);
    $file 			= $dir.DIRECTORY_SEPARATOR.self::$TRAIT_PREFIX.$base.self::$TRAIT_TMP_SUFFIX.self::$TRAIT_EXT;
    $modules_dir 	= glob($dir.DIRECTORY_SEPARATOR.'*');
    $uses_php 		= '';

    if(is_file($file) === true) {

    	foreach($modules_dir as $module_dir){

    		if(is_dir($module_dir) === false) continue;

    		if($parent === false) 	self::trait_build_tmp($module_dir, $base);
    		else 					self::trait_build_tmp($module_dir, $parent.'\\'.$base);
    	}
    	return true;
    }
    foreach($modules_dir as $module_dir){

      if(is_dir($module_dir) === false) continue;

      $uses_php .= "\t".'use '.self::$TRAIT_PREFIX.basename($module_dir).';'."\n";
    }
    if($parent === false) $parent = $base;

    $content = '<?php
namespace '.$parent.'\\'.$base.';

trait '.self::$TRAIT_PREFIX.$base.self::$TRAIT_TMP_SUFFIX.' {

'.$uses_php.'
}
?>';
    file_put_contents($file, $content);
    chmod($file, '0777');

    foreach($modules_dir as $module_dir){

      if(is_dir($module_dir) === false) continue;

      if($parent === false) self::trait_build_tmp($module_dir, $base);
      else 					self::trait_build_tmp($module_dir, $parent.'\\'.$base);
    }
    return true;
  }
}
trait trait_CONST_dir_class{

  private static $CLASS_PREFIX		= 'class_';
  private static $CLASS_EXT			= '.php';

  public static function class_build_load_all($dir, $parent = false){

    self::class_build($dir, $parent);

    $base 			= basename($dir);
    $file 			= $dir.DIRECTORY_SEPARATOR.self::$CLASS_PREFIX.$base.self::$CLASS_EXT;
    $modules_dir 	= glob($dir.DIRECTORY_SEPARATOR.'*');

    require_once $file;

    foreach($modules_dir as $module_dir){

      if(is_dir($module_dir) === false) continue;

      if($parent === false) self::class_build_load_all($module_dir, $base);
      else 					self::class_build_load_all($module_dir, $parent.'\\'.$base);
    }
    return true;
  }
  public static function class_build($dir, $parent = false){

    $base 			= basename($dir);
    $file 			= $dir.DIRECTORY_SEPARATOR.self::$CLASS_PREFIX.$base.self::$CLASS_EXT;
    $modules_dir 	= glob($dir.DIRECTORY_SEPARATOR.'*');

    if(is_file($file) === true) {

    	foreach($modules_dir as $module_dir){

    		if(is_dir($module_dir) === false) continue;

    		if($parent === false) 	self::class_build($module_dir, $base);
    		else 					self::class_build($module_dir, $parent.'\\'.$base);
    	}
    	return true;
    }
    if($parent === false) {

      $class = '<?php
namespace '.$base.';

class '.$base.' ';
    }
    else {

      $class = '<?php
namespace '.$parent.';

class '.$base.' extends \\'.$parent.' ';
    }
    if($parent === false) $parent = $base;

    $content = $class.' {

  // use \\'.$parent.'\\'.self::$TRAIT_PREFIX.$base.';
}
?>';
    $res = file_put_contents($file, $content);

   	chmod($file, '0777');

    $modules_dir = glob($dir.DIRECTORY_SEPARATOR.'*');

    foreach($modules_dir as $module_dir){

		if(is_dir($module_dir) === false) continue;

    	if($parent === false) 	self::class_build($module_dir, $base);
    	else 					self::class_build($module_dir, $parent.'\\'.$base);
    }
    return true;
  }
}
class CONST_dir{

  use trait_CONST_dir_trait;
  use trait_CONST_dir_class;

  public static function load($dir, $parent = false){

    self::trait_build_load_all($dir, $parent);
    self::class_build_load_all($dir, $parent);
  }
}
CONST_dir::load(dirname(__FILE__));

?>
