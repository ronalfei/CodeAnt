<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     cut_word<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @return string
 */
function smarty_modifier_cut_word($title, $length, $type=0)
{
	if (strlen($title)>$length)
	{
		$temp = 0;
		for($i=0; $i<$length; $i++)
		{
			if (@ord($title[$i]) > 128)
			{
				if (($i+1)<$length && @ord($title[$i+1]) >= 64 && @ord($title[$i+1]) < 255 && @ord($title[$i+1]) != 127)
				{
					$temp++;
					$i++ ;
				}
				$temp++;
			}
		}
		if ($temp%2 == 0)
		$title = substr($title,0,$length);
		else
		$title = substr($title,0,$length+1);
		if($type==0)
		{
			$title = $title."��";
		}
	}
	return $title;
}
/*$outstr = "";    //----��ʼ������ַ�----
 $chars = str_replace("\n", "", $chars); //----ȥ������--(��Щ��������)--
 //----ȥ�����в���ص�Html��ǩ �����Լ����� �������Խ��а�ȫ����Ҳ����----
 $chars = preg_replace("!(<html> )|(<html xml(.+?)> )|(<head>(.+?)</head> )|(<title>(.+?)</title> )|(<meta(.+?)> )|(<script>(.+?)</script> )|(<script(.+?)>(.+?)</script> )|(<OBJECT(.+?)>(.+?)</OBJECT> )|(<iframe(.+?)></iframe> )|((<form(.+?)>(.+?)</form> ))|(<body(.+?)> )|(</body> )|(</html> )!is", "", $chars);
 $chars = str_replace("<", "\n<", $chars);
 $chars = str_replace(">", ">\n", $chars);
 $chars = explode("\n", $chars);  //----�ָ�������----
 $eachlinelens = array(); //----ÿһ����html��ǩ�е��ַ���
 $textline = array();//----���������ֵ��еļ���
 /*
 ���������� �������ֵķǿ��б��浽���� ͬʱ�������е��кű��浽����

 foreach ($chars as $key => $val)
 {
 if ($val != "" && $val{0} != "<")
 {
 $eachlinelens[$key] = strlen($val);
 $textline[] = $key;
 }
 }
 //----���������ֵĴ��ڲſ�ʼ��ȡ---
 if (!empty($textline))
 {
 $strlens = array_sum($eachlinelens); //----�ܹ������ֽ�
 /*----����ȡ���ַ�����ܵ��ַ��� ��ֱ�������----
 if ($strlens > $cutlen)
 {
 /*
 �ҳ���Ҫ����ȡ�ַ���к�
 	
 $len = 0; //----��ʼ�����ֳ���
 foreach ($eachlinelens as $key => $val)
 {
 $beforelens = $len; //----֮ǰ�����еĳ���----
 $len += $val;  //----�ۼƳ���---
 if ($len >= $cutlen) //----�����Ѿ�����
 {
 $cutline = $key;            //---������Ҫ����ȡ�ַ����----
 break;                        //----�˳�----
 }
 }
 $cutinline = $cutlen - $beforelens; //----���ڽ�ȡ����----
 	
 $j = 0; //----��ʼ��AscII�����127���ַ��ܺ�
 /*
 ���濪ʼ��ȡ����
 	
 for ($i=0; $i < $cutinline; $i++)
 {
 if (ord($chars[$cutline]{$i}) > 127)
 {
 $j++;
 }
 }
 //----�������AscII����127���ַ��ܺ���2�ı�����ԭ�ƻ���ȡ�����򣬽�һλ
 	
 if (is_int($j/2))
 {
 if($type=="1")
 {
 $chars[$cutline] = substr($chars[$cutline],0, $cutinline) ;//. "... (�� $strlens �ֽ�)";
 }
 else
 {
 $chars[$cutline] = substr($chars[$cutline],0, $cutinline)."...";//(�� $strlens �ֽ�)";
 }
 }
 else
 {
 //echo $chars[$cutline];
 if($type=="1")
 {
 $chars[$cutline] = substr($chars[$cutline],0, $cutinline + 1) ;//. "... (�� $strlens �ֽ�)";
 }
 else
 {
 $chars[$cutline] = substr($chars[$cutline],0, $cutinline + 1). "...";//(�� $strlens �ֽ�)";
 }
 echo $cutinline + 1;
 echo $chars[$cutline];
 exit;
 }
 foreach ($chars as $key => $val)
 {
 if ($key <= $cutline)  //----�ڱ���ȡ��֮ǰ��ȫ�����
 {
 $outstr .= $val . "\n";
 }
 else
 {
 if (in_array($key, $textline) || $val == "" || preg_match("!(<br> )|(<br/> )|(<br /> )|(<p> )|(</p> )!", $val))
 {
 $outstr .= "";    //-----���е������У�Ϊ�˱������ۣ����з��У�ȫ���ÿհ״���
 }
 else
 {
 $outstr .=  $val  . "\n";
 }
 }
 }
 }
 else
 {
 $outstr = implode("\n", $chars);// . "(�� $strlens �ֽ�)";
 }
 }
 return  $outstr;
 }
 /* vim: set expandtab: */


?>
