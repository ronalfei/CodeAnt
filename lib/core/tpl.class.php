<?php
/**
 * 模板引擎类tpl
 *
 */
class tpl
{
	public		$smarty;				//引用smarty的实例
	private		$benchmark ;
	/**
	 * tpl构造函数
	 *
	 */
	public function __construct($benchmark)
	{
		$this->smarty =  new Smarty();
		$this->config();
		$this->benchmark = $benchmark;
	}

	private function config()
	{
		$this->setCacheDir(_SMARTY_CACHE_DIR);
		$this->setCompileDir(_SMARTY_COMPILE_DIR);
		$this->setConfigDir(_SMARTY_CONFIG_DIR);
		$this->setLeftTag(_SMARTY_LEFT_DELIMITER);
		$this->setRightTag(_SMARTY_RIGHT_DELIMITER);
		$this->setTplDir(_SMARTY_TEMPLATE_DIR);
		$this->smarty->compile_check = _SMARTY_COMPILE_CHECK;
		$this->smarty->debugging = _SMARTY_DEBUGGING;
		$this->smarty->caching = _SMARTY_CACHEING;
	}

	/**
	 * 设置模板文件目录
	 *
	 * @param string $dir
	 */
	private function setTplDir($dir)
	{
		$this->smarty->template_dir = $dir;
	}

	/**
	 * 设置模板配置目录
	 *
	 * @param string $dir
	 */
	private function setConfigDir($dir)
	{
		$this->smarty->config_dir = $dir;
	}

	/**
	 * 设置模板缓存目录
	 *
	 * @param string $dir
	 */
	private function setCacheDir($dir)
	{
		$this->smarty->cache_dir = $dir;
	}

	/**
	 * 设置模板编译目录
	 *
	 * @param string $dir
	 */
	private function setCompileDir($dir)
	{
		$this->smarty->compile_dir = $dir;
	}

	/**
	 * 设置模板左语法标记
	 *
	 * @param string $leftTag
	 */
	private function setLeftTag($leftTag)
	{
		$this->smarty->left_delimiter = $leftTag;
	}

	/**
	 * 设置模板右语法标记
	 *
	 * @param string $rightTag
	 */
	private function setRightTag($rightTag)
	{
		$this->smarty->right_delimiter = $rightTag;
	}

	/**
	 * 模板赋值函数
	 *
	 * @param string $tplvar
	 * @param string $phpvar
	 */
	public function assign($tplvar,$phpvar)
	{
		$this->smarty->assign($tplvar,$phpvar);
	}

	/**
	 * 模板引用赋值函数
	 *
	 * @param string $tplvar
	 * @param string $phpvar
	 */
	public function assign_by_ref($tplvar,$phpvar)
	{
		switch(_SMARTY_VERSION){
			case 2:
				$this->smarty->assign_by_ref($tplvar,$phpvar);
			break;
			case 3:
                $this->smarty->assignByRef($tplvar,$phpvar);
            break;
		}
	}
	
	public function assignByRef($tplvar, $phpvar)
	{
		switch(_SMARTY_VERSION){
            case 2:
                $this->smarty->assign_by_ref($tplvar,$phpvar);
            break;
            case 3:
                $this->smarty->assignByRef($tplvar,$phpvar);
            break;
        }
	}


	/**
	 * 模板内容读取
	 *
	 * @param string $tplName
	 * @return string 整个模板文件内容
	 */
	public function fetch($tplName, $cache_id=null, $compile_id=null)
	{
		return $this->smarty->fetch($tplName, $cache_id, $compile_id);
	}

	/**
	 * 模板显示函数
	 * @abstract 显示模板
	 * @param string $tplName
	 * @param int $cache_id
	 * @param int $compile_id
	 */
	public function display($tplName,$cache_id=null,$compile_id=null)
	{
		$this->benchmark->mark('smarty_parse_start');
		$this->smarty->display($tplName,$cache_id=null,$compile_id=null);
		$this->benchmark->mark('smarty_parse_end');
	}
}
?>
