<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     ubb<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|ubb}
 * @version  1.0
 * @author   Monte Ohrt <monte@ispi.net>
 * @param string
 * @return string
 */
function smarty_modifier_ubb($Text)
{
	$Text=trim($Text);
	$Text=htmlspecialchars($Text);
	$Text=ereg_replace("&lt;br&gt;","<br>",$Text);
	$Text=ereg_replace(" ","&nbsp;",$Text);
	$Text=ereg_replace("\r","<br>",$Text);
	$Text=preg_replace("/\\t/is","<br>  ",$Text);
	$Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
	$Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
	$Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
	$Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
	$Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
	$Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
	$Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
	$Text=preg_replace("/\[url\](http:\/\/.+?)\[\/url\]/is","<a  href=\\1>\\1</a>",$Text);
	$Text=preg_replace("/\[url\](.+?)\[\/url\]/is","<a  href=\"http://\\1\">http://\\1</a>",$Text);
	$Text=preg_replace("/\[url=(http:\/\/.+?)\](.*)\[\/url\]/is","<a  href=\\1>\\2</a>",$Text);
	$Text=preg_replace("/\[url=(.+?)\](.*)\[\/url\]/is","<a  href=http://\\1>\\2</a>",$Text);
	$Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img  src=\\1>",$Text);
	$Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font  color=\\1>\\2</font>",$Text);
	$Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font  size=\\1>\\2</font>",$Text);
	$Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
	$Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
	$Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
	$Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a  href=\\1>\\1</a>",$Text);
	$Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
	$Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
	$Text=preg_replace("/\[IMG:(.*?)\]/i","<img src=\"/template/myportal/default/images/face/\\1.gif\" alt=\"\\1\">",$Text);
	$Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><font  size='1'  face='Courier  New'>quote:</font><hr>\\1<hr></blockquote>",  $Text);
	$Text=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><font  size='1'  face='Times  New  Roman'>code:</font><hr  color='lightblue'><i>\\1</i><hr  color='lightblue'></blockquote>",  $Text);
	$Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div  style='text-align:  left;  color:  darkgreen;  margin-left:  5%'><br><br>--------------------------<br>\\1<br>--------------------------</div>",  $Text);
	return $Text;
}

/* vim: set expandtab: */

?>
