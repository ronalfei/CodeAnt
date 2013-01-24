<?php

class debug {
	private $language=Array();
	private $benchmark ;
	function __construct(&$benchmark)
	{
		$this->benchmark = $benchmark;
		$this->language['profiler_database']			= 'DATABASE';
		$this->language['profiler_controller_info']		= 'CLASS/METHOD';
		$this->language['profiler_benchmarks']			= 'BENCHMARKS';
		$this->language['profiler_queries']				= 'QUERIES';
		$this->language['profiler_get_data']			= 'GET DATA';
		$this->language['profiler_post_data']			= 'POST DATA';
		$this->language['profiler_uri_string']			= 'URI STRING';
		$this->language['profiler_memory_usage']		= 'MEMORY USAGE';
		$this->language['profiler_no_db']				= 'Database driver is not currently loaded';
		$this->language['profiler_no_queries']			= 'No queries were run';
		$this->language['profiler_no_post']				= 'No POST data exists';
		$this->language['profiler_no_get']				= 'No GET data exists';
		$this->language['profiler_no_uri']				= 'No URI data exists';
		$this->language['profiler_no_memory']			= 'Memory Usage Unavailable';
	}
	private function lang($key)
	{
		return $this->language[$key];
	}
	// --------------------------------------------------------------------

	/**
	 * Auto Profiler
	 *
	 * This function cycles through the entire array of mark points and
	 * matches any two points that are named identically (ending in "_start"
	 * and "_end" respectively).  It then compiles the execution times for
	 * all points and returns it as an array
	 *
	 * @access	private
	 * @return	array
	 */
	private function _compile_benchmarks()
	{
		$profile = array();
		foreach ($this->benchmark->marker as $key => $val)
		{
			// We match the "end" marker so that the list ends
			// up in the order that it was defined
			if (preg_match("/(.+?)_end/i", $key, $match))
			{
				if (isset($this->benchmark->marker[$match[1].'_end']) AND isset($this->benchmark->marker[$match[1].'_start']))
				{
					$profile[$match[1]] = $this->benchmark->elapsed_time($match[1].'_start', $key);
				}
			}
		}

		// Build a table containing the profile data.
		// Note: At some point we should turn this into a template that can
		// be modified.  We also might want to make this data available to be logged

		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #990000;padding:6px 10px 10px 10px;margin:0 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#990000;">&nbsp;&nbsp;'.$this->lang('profiler_benchmarks').'&nbsp;&nbsp;</legend>';
		$output .= "\n";
		$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";

		foreach ($profile as $key => $val)
		{
			$key = ucwords(str_replace(array('_', '-'), ' ', $key));
			$output .= "<tr><td width='50%' style='color:#000;font-weight:bold;background-color:#ddd;'>".$key."&nbsp;&nbsp;</td><td width='50%' style='color:#990000;font-weight:normal;background-color:#ddd;'>".$val."</td></tr>\n";
		}

		$output .= "</table>\n";
		$output .= "</fieldset>";
			
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Compile Queries
	 *
	 * @access	private
	 * @return	string
	 */
	private function _compile_queries()
	{
		global $codeAnt;
		if(empty($codeAnt->db)){
			$dbs=array();
		}else{
			$dbs = $codeAnt->db->dbdebug->getQueries();
		}
		//print_r($dbs);
		if (count($dbs) == 0)
		{
			$output  = "\n\n";
			$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->lang('profiler_queries').'&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";
			$output .="<tr><td width='100%' style='color:#0000FF;font-weight:normal;background-color:#eee;'>".$this->lang('profiler_no_db')."</td></tr>\n";
			$output .= "</table>\n";
			$output .= "</fieldset>";
				
			return $output;
		}

		// Load the text helper so we can highlight the SQL
		//$this->CI->load->helper('text');

		// Key words we want bolded
		$highlight = array('SELECT','select' , 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');

		$output  = "\n\n";
			
		foreach ($dbs as $dbk=>$dbv)
		{
			$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;'.$this->lang('profiler_database').':&nbsp; '.$dbk.'&nbsp;&nbsp;&nbsp;'.$this->lang('profiler_queries').': '.count($dbv).'&nbsp;&nbsp;&nbsp;</legend>';
			$output .= "\n";
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";

			if (count($dbv) == 0)
			{
				$output .= "<tr><td width='100%' style='color:#0000FF;font-weight:normal;background-color:#eee;'>".$this->lang('profiler_no_queries')."</td></tr>\n";
			}
			else
			{
				foreach ($dbv as $key => $val)
				{
					$time = number_format($val['time'], 6);

					$sql = $this->highlight_code($val['sql'], ENT_QUOTES);

					foreach ($highlight as $bold)
					{
						$sql = str_replace($bold, '<strong>'.$bold.'</strong>', $sql);
					}
						
					$output .= "<tr><td width='1%' valign='top' style='color:#990000;font-weight:normal;background-color:#ddd;'>".$time."&nbsp;&nbsp;</td><td style='color:#000;font-weight:normal;background-color:#ddd;'>".$sql."</td></tr>\n";
				}
			}
				
			$output .= "</table>\n";
			$output .= "</fieldset>";
				
		}

		return $output;
	}


	// --------------------------------------------------------------------

	/**
	 * Compile $_GET Data
	 *
	 * @access	private
	 * @return	string
	 */
	private function _compile_get()
	{
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #cd6e00;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#cd6e00;">&nbsp;&nbsp;'.$this->lang('profiler_get_data').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (count($_GET) == 0)
		{
			$output .= "<div style='color:#cd6e00;font-weight:normal;padding:4px 0 4px 0'>".$this->lang('profiler_no_get')."</div>";
		}
		else
		{
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";

			foreach ($_GET as $key => $val)
			{
				if ( ! is_numeric($key))
				{
					$key = "'".$key."'";
				}
					
				$output .= "<tr><td width='50%' style='color:#000;background-color:#ddd;'>&#36;_GET[".$key."]&nbsp;&nbsp; </td><td width='50%' style='color:#cd6e00;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val))
				{
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, true))) . "</pre>";
				}
				else
				{
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}
				
			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Compile $_POST Data
	 *
	 * @access	private
	 * @return	string
	 */
	private function _compile_post()
	{
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #009900;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#009900;">&nbsp;&nbsp;'.$this->lang('profiler_post_data').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if (count($_POST) == 0)
		{
			$output .= "<div style='color:#009900;font-weight:normal;padding:4px 0 4px 0'>".$this->lang('profiler_no_post')."</div>";
		}
		else
		{
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";

			foreach ($_POST as $key => $val)
			{
				if ( ! is_numeric($key))
				{
					$key = "'".$key."'";
				}
					
				$output .= "<tr><td width='50%' style='color:#000;background-color:#ddd;'>&#36;_POST[".$key."]&nbsp;&nbsp; </td><td width='50%' style='color:#009900;font-weight:normal;background-color:#ddd;'>";
				if (is_array($val))
				{
					$output .= "<pre>" . htmlspecialchars(stripslashes(print_r($val, true))) . "</pre>";
				}
				else
				{
					$output .= htmlspecialchars(stripslashes($val));
				}
				$output .= "</td></tr>\n";
			}
				
			$output .= "</table>\n";
		}
		$output .= "</fieldset>";

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Show query string
	 *
	 * @access	private
	 * @return	string
	 */
	private function _compile_uri_string()
	{
		$uri	 = $_SERVER['REQUEST_URI'];
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #000;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#000;">&nbsp;&nbsp;'.$this->lang('profiler_uri_string').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if ($uri == '')
		{
			$output .= "<div style='color:#000;font-weight:normal;padding:4px 0 4px 0'>".$this->lang('profiler_no_uri')."</div>";
		}
		else
		{
			$output .= "<div style='color:#000;font-weight:normal;padding:4px 0 4px 0'>".$uri."</div>";
		}

		$output .= "</fieldset>";

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Show the controller and function that were called
	 *
	 * @access	private
	 * @return	string
	 */
	private function _compile_controller_info()
	{
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #995300;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#995300;">&nbsp;&nbsp;'.$this->lang('profiler_controller_info').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		$output .= "<div style='color:#995300;font-weight:normal;padding:4px 0 4px 0'>".$this->CI->router->fetch_class()."/".$this->CI->router->fetch_method()."</div>";


		$output .= "</fieldset>";

		return $output;
	}
	// --------------------------------------------------------------------

	/**
	 * Compile memory usage
	 *
	 * Display total used memory
	 *
	 * @access	public
	 * @return	string
	 */
	private function _compile_memory_usage()
	{
		$output  = "\n\n";
		$output .= '<fieldset style="border:1px solid #5a0099;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
		$output .= "\n";
		$output .= '<legend style="color:#5a0099;">&nbsp;&nbsp;'.$this->lang('profiler_memory_usage').'&nbsp;&nbsp;</legend>';
		$output .= "\n";

		if( function_exists('memory_get_usage')&&( $usage = memory_get_usage() )!= '')
		{
			$byte	= number_format($usage);
			$kbyte	= $usage/1024;
			$mbyte	= round($kbyte/1024,2);
			if($mbyte>=1){
				$useage_string = $mbyte.' Mbyte ';
			}elseif($kbyte>=1){
				$useage_string = $kbyte.' Kbyte ';
			}else{
				$useage_string = $byte.' byte ';
			}
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".$useage_string.'</div>';
		}else{
			$output .= "<div style='color:#5a0099;font-weight:normal;padding:4px 0 4px 0'>".$this->lang('profiler_no_memory_usage')."</div>";
		}

		$output .= "</fieldset>";

		return $output;
	}

	// --------------------------------------------------------------------

	function highlight_code($str)
	{
		// The highlight string function encodes and highlights
		// brackets so we need them to start raw
		$str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

		// Replace any existing PHP tags to temporary markers so they don't accidentally
		// break the string out of PHP, and thus, thwart the highlighting.

		$str = str_replace(array('<?', '?>', '<%', '%>', '\\', '</script>'),
		array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'), $str);

		// The highlight_string function requires that the text be surrounded
		// by PHP tags, which we will remove later
		$str = '<?php '.$str.' ?>'; // <?

		// All the magic happens here, baby!
		$str = highlight_string($str, TRUE);

		// Prior to PHP 5, the highligh function used icky <font> tags
		// so we'll replace them with <span> tags.

		if (abs(PHP_VERSION) < 5)
		{
			$str = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $str);
			$str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
		}

		// Remove our artificially added PHP, and the syntax highlighting that came with it
		$str = preg_replace('/<span style="color: #([A-Z0-9]+)">&lt;\?php(&nbsp;| )/i', '<span style="color: #$1">', $str);
		$str = preg_replace('/(<span style="color: #[A-Z0-9]+">.*?)\?&gt;<\/span>\n<\/span>\n<\/code>/is', "$1</span>\n</span>\n</code>", $str);
		$str = preg_replace('/<span style="color: #[A-Z0-9]+"\><\/span>/i', '', $str);
			
		// Replace our markers back to PHP tags.
		$str = str_replace(array('phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
		array('&lt;?', '?&gt;', '&lt;%', '%&gt;', '\\', '&lt;/script&gt;'), $str);

		return $str;
	}


	// ------------------------------------------------------------------------


	/**
	 * Run the Profiler
	 *
	 * @access	private
	 * @return	string
	 */
	public function run()
	{
		$this->benchmark->mark('total_execute_time_end');
		$output = "<div id='codeAnt_debug' style='clear:both;background-color:#fff;padding:10px;display:none'>";

		$output .= $this->_compile_uri_string();
		//$output .= $this->_compile_controller_info();			在非mvc模式下,不需要也没有此项的显示
		$output .= $this->_compile_memory_usage();

		$output .= $this->_compile_get();
		$output .= $this->_compile_post();
		$output .= $this->_compile_queries();
		$output .= $this->_compile_benchmarks();
		$output .= '</div>';

		return $output;
	}

	public function displayProfile()
	{
		echo "<script>function show_profile(){ var obj=document.getElementById('codeAnt_debug');if(obj.style.display=='none'){obj.style.display='inline';}else{obj.style.display='none';} }</script>";
		echo "<div onclick='show_profile()' style='color:white;cursor:pointer'>显示调试信息</div>",$this->run();
	}
	public function display()
	{
		$this->displayProfile();
	}

}
?>
