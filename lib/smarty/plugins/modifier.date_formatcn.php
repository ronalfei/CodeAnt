<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Include the {@link shared.make_timestamp.php} plugin
 */
//require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     date_format<br>
 * Purpose:  format datestamps via strftime<br>
 * Input:<br>
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
include_once("modifier.date_format.php");

function smarty_modifier_date_formatcn($string, $format="%b %e, %Y", $default_date=null)
{
	$cweekday = array("日","一","二","三","四","五","六");
	$now = getdate(strtotime($string));
	$cur_wday=$now['wday'];
	$format = str_replace('%a',$cweekday[$cur_wday],$format);
	$format = str_replace('%A','星期' . $cweekday[$cur_wday],$format);
	return smarty_modifier_date_format($string, $format,$default_date);
}

/* vim: set expandtab: */

?>

