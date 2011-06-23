<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty regex_replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     blog_replace<br>
 * Purpose:  regular epxression search/replace
 * @link http://smarty.php.net/manual/en/language.modifier.regex.replace.php
 *          regex_replace (Smarty online manual)
 * @param string
 * @return string
 */
function smarty_modifier_blog_replace($string)
{
	$string = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i","&111n\\2",$string);
	$string = preg_replace("/<script(.*?)>(.*?)<\/script>/si","",$string);
	$string = preg_replace("/<iframe(.*?)>(.*?)<\/iframe>/si","",$string);
	return $string;
}

/* vim: set expandtab: */
?>
