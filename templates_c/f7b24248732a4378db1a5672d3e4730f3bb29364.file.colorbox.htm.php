<?php /* Smarty version Smarty-3.1.7, created on 2012-03-31 15:56:58
         compiled from "/opt/www/codeAnt/templates/colorbox.htm" */ ?>
<?php /*%%SmartyHeaderCode:11255389034f76b8cacd42b6-29974307%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7b24248732a4378db1a5672d3e4730f3bb29364' => 
    array (
      0 => '/opt/www/codeAnt/templates/colorbox.htm',
      1 => 1329622829,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11255389034f76b8cacd42b6-29974307',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f76b8cacd670',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f76b8cacd670')) {function content_4f76b8cacd670($_smarty_tpl) {?><script type="text/javascript">
	$(document).ready(function(){
		$("a[rel='example1']").colorbox();
		$("a[rel='example2']").colorbox({transition:"fade"});
		$("a[rel='example3']").colorbox({transition:"none", width:"75%", height:"75%"});
		$("a[rel='example4']").colorbox({slideshow:true});
		$(".example5").colorbox({
			width:"800px",height:"450px",
			onComplete:function() {bodyLoaded()}
		});
		$(".example6").colorbox({iframe:true, innerWidth:425, innerHeight:344});
		$(".example7").colorbox({width:"80%", height:"80%", iframe:true});
		$(".example8").colorbox({width:"50%", inline:true, href:"#inline_example1"});
		$(".example9").colorbox({
			onOpen:function(){ alert('onOpen: colorbox is about to open'); },
			onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
			onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
			onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
			onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
		});
		$(".example10").colorbox({
			width:"200px",height:"60px",
			onLoad:function() { setTimeout($.colorbox.close, 500);}
		});
		$("#click").click(function(){ 
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
<?php }} ?>