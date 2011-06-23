<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty left_time modifier plugin
 *
 * Type:     modifier<br>
 * Name:     left_time<br>
 * Purpose:  format strings via sprintf
 * @link http://smarty.php.net/manual/en/language.modifier.string.format.php
 *          left_time (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_left_time($time)
{
	$s1 = strtotime($time);
	$s2 = time();
	$s = $s1-$s2;
	if($s <= 0){
		return '已关闭';
	}else{
		$dy = intval($s/86400);
		$ho = intval(($s%86400)/3600);
		$mi = intval(($s%3600)/60); 
		$ss = $s % 60;
		
		return "剩余 {$dy}天 {$ho}小时 {$mi}分 {$ss}秒";
	}
}

/* vim: set expandtab: */

?>
