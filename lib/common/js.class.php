<?php
class js
{
	/**
	 * 让父窗口自动刷新一下.避免有些浏览器有重复提交数据的情况.
	 */
	static public function reloadParent()
	{
		echo '<script> var url = parent.window.location.href;parent.window.location.href=url; </script>';
	}
	
	
	static public function href($url)
	{
		echo "<script> location.href='{$url}'; </script>";	
	}
	
	static public function parentHref($url)
	{
		echo "<script> parent.window.location.href='{$url}'; </script>";
	}
	static public function reload()
	{
		echo '<script> window.location.reload(); </script>';
	}
	static public function alert($msg)
	{
		echo "<script> alert('{$msg}'); </script>";
	}
	static public function error($msg)
	{
		die($msg);
	}
	
	static public function warning($msg)
	{
		echo $msg;
	}
	
	static public function goBack($step=-1)
	{
		if(empty($step))
		{
			$step=-1;
		}
		echo "<script> history.go({$step}); </script>";
		die();
	}
	static public function topReload()
	{
		
		echo '<script>  parent.window.banner.location.reload(); </script>';
	}
	
	static public function parentTopReload()
	{
		
		echo '<script>  parent.parent.window.banner.location.reload(); </script>';
	}
	
	static public function ParentUnBlockUI()
	{
		echo '<script>  parent.$.unblockUI(); </script>';
	}
	
	static public function unBlockUI()
	{
		echo '<script>  $.unblockUI(); </script>';
	}
	static public function parentFocus($id)
	{
		echo "<script>  parent.\$id('{$id}').focus(); </script>";
	}
}
?>