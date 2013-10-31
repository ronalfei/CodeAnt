<?php

/**
 * @name：  分页类
 * @author：fei.wang
 * @date：  2007-11-22
 * @modify: 2009-11-30
 */
class page
{
	private	$total;									//总记录数
	private	$displayPage;							//每页显示记录数
	private	$totalPage;								//总页数
	private	$fileName;								//文件的绝对路径
	private	$previousPage;							//上一页
	private	$pageNum;								//当前页	
	private	$nextPage;								//下一页
	private	$start;									//显示数起点
	private	$scriptName;							//当前文件对于该站点的绝对路径
	private	$url;									//当前页的http路径
	private	$requestUrl;							//上次请求的URL
	private	$condition=array();						//外部条件
	private $previousUrl;							//上一页的url链接地址
	private $nextUrl;								//下一页的链接地址
	public	$limitSql;								//分页查询的limit条件字符串


	/**
	 * 构造函数
	 *
	 * @param int		$total
	 * @param int		$displayPage
	 * @param int		$pageNum
	 * @param string	$condition
	 */
	public function __construct($total,$pageNum,$displayPage=20)
	{
		$this -> displayPage	= $displayPage;
		$this -> scriptName		= $_SERVER['SCRIPT_NAME'];			//文件对于站点的绝对路径
		$this -> fileName		= $_SERVER['SCRIPT_FILENAME'];		//文件绝对路径
		$this -> total			= $total;
		$this -> pageNum		= $pageNum;
		$this -> requestUrl		= $_SERVER['REQUEST_URI'];			//获取上次请求的URL
		$this -> setUrl();

		$this -> parseRequestUrl();
		$this -> setTotalPage();
		$this -> judgePageNum();
		$this -> setPage();
		$this -> setOffset();
		$this -> setLimitSql();
		$this -> previousPageUrl();
		$this -> nextPageUrl();
	}

	private function setUrl()
	{
		$url_info = parse_url($_SERVER['REQUEST_URI']);
		$this->url = $url_info['path'];
	}


	/**
	 * 获取总页数
	 *
	 */
	private function setTotalPage()
	{
		$this->totalPage = ceil($this->total/$this->displayPage);
	}


	/**
	 * 判断当前页的值是否合法
	 *
	 * 不合法则重置它
	 */
	private function judgePageNum()
	{
		if(empty($this->pageNum)||$this->pageNum < 1)
		{
			$this->pageNum = 1;
		}
		if($this->pageNum > $this->totalPage )
		{
			if($this->totalPage==0)							//曾加总页数可能会为0的情况
			{
				$this->pageNum = 1;
			}
			else
			{
				$this->pageNum = $this->totalPage;
			}
		}
	}


	/**
	 * 根据当前页设置上一页和下一页的值
	 *
	 */
	private function setPage()
	{
		if($this->totalPage <= 1 )
		{
			$this->previousPage = 1;
			$this->nextPage     = 1;
		}
		else
		{
			if($this->pageNum <= 1)
			{
				$this->previousPage = 1;
				$this->nextPage		= 1 + $this->pageNum;
			}
			else if($this->pageNum >= $this->totalPage)
			{
				$this->previousPage = $this->totalPage - 1;
				$this->nextPage		= $this->totalPage;
			}
			else
			{
				$this->previousPage = $this->pageNum - 1;
				$this->nextPage		= $this->pageNum + 1;
			}
		}
	}


	/**
	 * 设置sql语句的查询起始记录数
	 * 即偏移数
	 */
	private function setOffset()
	{
		$this->start = ($this->pageNum - 1)*$this->displayPage;
	}


	/**
	 * 返回sql语句中的分页条件
	 * 本函数只针对Mysql
	 */
	private function setLimitSql()
	{
		$this->limitSql = " limit $this->start,$this->displayPage ";
	}


	/**
	 * 解析当前请求的url
	 * 解析出所需GET的数据
	 * 并设置$this->condition为该类数据的数组
	 */
	private function parseRequestUrl()
	{
		$urlArray = array();
		$urlArray = parse_url($this->requestUrl);
		if(array_key_exists('query',$urlArray))
		{
			$temp = urldecode($urlArray['query']);
			if(preg_match('/pagenum/i',$temp))
			{
				$tempArr = explode('&',$temp);
				array_pop($tempArr);
				$this->condition = $tempArr;
					
			}
			else
			{
				$tempArr = explode('&',$temp);
				$this->condition = $tempArr;
			}
		}
	}


	/**
	 * 转换GET数据的数组
	 * 并根据该数组打印出form表单中的隐藏表单
	 * @return 隐藏表单字符串
	 */
	private function getCondition()
	{
		$conArr = array();
		$temp   = "";
		if(!empty($this->condition))
		{
			foreach($this->condition as $value)
			{
				$a = explode('=',$value);
				if(empty($a[1])){
					continue;
				}else{
					$conArr[] = array('name'=>$a[0],'value'=>$a[1]);
				}
			}
		}
		if(!empty($conArr))
		{
			foreach($conArr as $hidden)
			{
				$temp = $temp."<input type='hidden' name='".$hidden['name']."' value='".$hidden['value']."' />";
			}
		}
		return $temp;
	}


	/**
	 * 替换回解析后的 = 和 &
	 *
	 * @param string $encodeUrl
	 * @return string url
	 */
	private function urlReplace($encodeUrl)
	{
		$encodeUrl = str_replace('%3D','=',$encodeUrl);
		$encodeUrl = str_replace('%26','&',$encodeUrl);
		return $encodeUrl;
	}


	/**
	 * 设置上一页的url链接地址
	 */
	private function previousPageUrl()
	{
		if(!empty($this->condition))
		{
			$pre = urlencode(implode('&',$this->condition));
			$pre = $this->urlReplace($pre);
			$this->previousUrl = "$this->url?$pre&pagenum=$this->previousPage";
		}
		else
		{
			$this->previousUrl = "$this->url?pagenum=$this->previousPage";
		}
	}


	/**
	 * 设置下一页的url地址
	 *
	 */
	private function nextPageUrl()
	{
		if(!empty($this->condition))
		{
			$next = urlencode(implode('&',$this->condition));
			$next = $this->urlReplace($next);
			$this->nextUrl = "$this->url?$next&pagenum=$this->nextPage";
		}
		else
		{
			$this->nextUrl = "$this->url?pagenum=$this->nextPage";
		}
	}


	/**
	 * 输出分页的表单
	 *
	 * @param divClassName $div
	 * @param aClassName $a
	 * @param selectClassName $select
	 */
	public function printForm($div=null,$a=null,$select=null)
	{
		echo $this->returnForm($div,$a,$select);
	}


	/**
	 * 返回分页的表单字符串
	 *
	 * @param divClassName $div
	 * @param aClassName $a
	 * @param selectClassName $select
	 */
	public function returnForm($div=null,$a=null,$select=null)
	{
		$div	= isset($div)?$div:"";
		$a		= isset($a)?$a:"";
		$select	= isset($select)?$select:"";
		$temp   = array();
		$form   = "";
		if($this->total==0)
		{
			$temp[] = "<div align='right' class='$div' style='padding-right:20px'>";
			$temp[] = "共有 -<b>$this->total</b>- 条记录 ";
			$temp[] = " 共 -<b>$this->totalPage</b>- 页 ";	
			$temp[] = "</div>";
		}
		else
		{
			$temp[] = "<div align='right' class='$div' style='padding-right:20px'>";
			$temp[] = "<form name='pagination' action='$this->url' method='GET'>";
			$temp[] = $this->getCondition();					//打印出隐藏表单
			$temp[] = "共有 -<font color='red'><b>$this->total</b></font>- 条记录 ";
			$temp[] = " 共 -<font color='red'><b>$this->totalPage</b></font>- 页 ";
			
			if($this->pageNum==1){
				$temp[] = " <a class='$a' href='javascript:void(0)' style='color:gray'>上一页</a>  当前第 ";
			}else{
				$temp[] = " <a class='$a' href='$this->previousUrl'>上一页</a>  当前第 ";
			}
			 
			$temp[] = "<select id='pagenum' name='pagenum' class='$select' onchange='pagination.submit()'>";
			for($i=1;$i<=$this->totalPage;$i++)
			{
				$temp[] = "<option value='$i'";
				if($i==$this->pageNum) $temp[] = "selected";
				$temp[] = " >";
				$temp[] = "-$i-";
				$temp[] = "</option>";
			}
			$temp[] = "";
			$temp[] = "</select>";
			if($this->pageNum>=$this->totalPage){
				$temp[] = " 页 <a class='$a' href='javascript:void(0)' style='color:gray'>下一页</a> ";
			}else{
				$temp[] = " 页 <a class='$a' href='$this->nextUrl'>下一页</a> ";
			}
			 
			$temp[] = "</form>";
			$temp[] = "</div>";
		}
		 
		$form = implode(' ',$temp);
		 
		return $form;
	}


	/**
	 * 析够函数
	 * 对于分页类来说，它并不能做什么事情
	 * 为了结构的严谨,注销了该类的实例句柄
	 */
	public function __destruct()
	{
		if(isset($this))
		{
			unset($this);
		}
	}
}
?>
