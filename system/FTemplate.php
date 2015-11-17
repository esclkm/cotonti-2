<?php
/*
 replace
\{ -> {$
\{([^\}]+)\|([^\}]+)(\$this)([^\}]+)\} -> {$.php.\2\1\4}
\{([^\}]+)\|([^\}]+)\}  -> {$.php.\2}
\{([^\}]+)\|([^\(\}]+)\} -> {$.php.\2(\1)}
\{([^\}]+)\|([^\}]+)\} -> {$.php.\2}
<!-- ENDIF --> -> {/if}
<!-- ELSE --> -> {else}
<!-- BEGIN: MAIN --> ->
<!-- END: MAIN --> ->
<!--\s*IF\s+(.+?)--> ->{if \1}
<!-- ENDFOR --> -> {/foreach}
<!--\s*FOR\s+\{(.+?)\},\s*\{(.+?)\}\s*IN\s*\{(.+?)\}\s*--> -> {foreach \3 as \1 => \2}
 */

require_once $cfg['vendor_dir'].'/fenom/fenom.php';
Fenom::registerAutoload();

class FTemplate
{

	//добавляем новые методы
	private $blockVars = array();
	private $vars = array();
	private $templateFile = "";
	
	/**
	 * @var array Stores debug data
	 */
	protected static $debug_data = array();
	/**
	 * @var boolean Enables debug dumping
	 */
	protected static $debug_mode = false;
	/**
	 * @var boolean Prints debug mode screen
	 */
	protected static $debug_output = false;
	
	/**
	 * @var object Fenom class
	 */
	protected static $fenom = '';
	/**
	 * @var bool Fenom class inizialized status
	 */
	protected static $inicialized = false;	
	
	public function __construct($templateFile)
	{
		$cachevars = array();
		$this->templateFile = $templateFile;
		if(!self::$inicialized)
		{
			global $cfg;
			self::init(array(
				'cache_dir'    => $cfg['cache_dir'].'/fenom',
				'auto_reload' => true,
				'force_compile' => true
			));
		}
	}
	public function __toString()
    {
        return '';
    }
	
	/**
	 * Initializes static class configuration.
	 *
	 * Options:
	 * * cache_dir - Directory to store pre-compiled templates.
	 * * Adn all fenom configs https://github.com/fenom-template/fenom/blob/master/docs/en/configuration.md
	 * Default values:
	 * <code>
	 * $options = array(
	 *		'cache'        => false,
	 *		'cache_dir'    => '',
	 *		'auto_reload'  => true,
	 *		'force_compile'=> true,
	 *	);
	 * </code>
	 *
	 * @param array $options Fenom options
	 */	
	public static function init($options = array())
	{
		$defaults = array(
			'cache_dir'    => '',
			'auto_reload' => true,
			'force_compile' => true,
			'debug'        => false,
			'debug_output' => false,
		);

		$options = array_merge($defaults, $options);
		$cache = $options['cache_dir'];
		self::$debug_mode    = $options['debug'];
		self::$debug_output  = $options['debug_output'];
		
		unset($options['cache_dir']);
		unset($options['debug']);
		unset($options['debug_output']);
		
		self::$fenom = Fenom::factory('', $cache, $options);
		self::$inicialized = true;
		/**
		 * Modifier Format inixtime
		 * @param int $timestamp inixtime
		 * @param string $format time format
		 * @return string
		 */			
		self::$fenom->addModifier('date', function ($timestamp, $format='date_text') {
			return cot_date($format, $timestamp);
		});
		self::$fenom->addModifier('dump', function ($var) {
			return self::dump($var);
		});		
	}

	/**
	 * Assigns a template variable or an array of them
	 *
	 * @param mixed $name Variable name or array of values
	 * @param mixed $val Tag value if $name is not an array
	 * @param string $prefix An optional prefix for variable keys
	 * @return XTemplate $this object for call chaining
	 */
	public function assign($name, $val = NULL, $prefix = '')
	{
		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				$this->vars[$prefix.$key] = $val;
			}
		}
		else
		{
			$this->vars[$prefix.$name] = $val;
		}
		return $this;
	}
	
	/**
	 * Parses a varaiables into array
	 *
	 * @param string $block Block name
	 * @return XTemplate $this object for call chaining
	 */
	public function parse($block = 'MAIN')
	{
		$block_tree = explode('.', $block);
		unset($block_tree[0]);
		$depth = count($block_tree);
		if( !count($depth))
		{
			return true;
		}
		
		$k = 0;
		$vars_array = &$this->blockVars;
		foreach ($block_tree as $block_name)
		{
			$k++;
			if($k == $depth)
			{
				$vars_array[$block_name][] = $this->vars;
			}
			else
			{
				if(!isset($vars_array[$block_name]))
				{
					$vars_array[$block_name] = array();
				}
				$vars_array = &$vars_array[$block_name][count($vars_array[$block_name])-1];
			}
		}
	}
	public function setTemplate($templateFile)
	{
		$this->templateFile = $templateFile;		
	}	
	/**
	 * Returns all assigned variables
	 *
	 * @param string $block Block name
	 * @return string
	 */		
	public function getVariables($block = null)
	{
		return array_merge($this->blockVars, $this->vars,  array('PHP' => &$GLOBALS));		
	}

	
	/**
	 * Variable debug output handler for {var_name|dump}
	 *
	 * @param mixed $val Var value
	 * @return string
	 */
	private static function dump($val)
	{
		if(self::$debug_mode)
		{
			if($val == $GLOBALS)
			{
				//$val = '$GLOBALS array()';
			}
			echo '<ul class="dump">' . self::debugVar("dump", $val) . '</ul>';
			die();
		}
		return $val;
	}

	/**
	 * Debugging output of a tag name and current value
	 *
	 * @param string $name Tag name
	 * @param mixed $value Tag value, will be casted to string
	 * @param string $preffix Tag preffix
	 * @param int $level Current nesting level
	 * @return string A list elemented for debug output
	 */
	public static function debugVar($name, $value, $preffix = '', $level =0)
	{
		if(!empty($preffix))
		{
		//	$name = $preffix.'.'.$name;
		}
		if(is_null($value))
		{
			return false;
		}
		if (is_bool($value))
		{
			$val_disp = '<em>[bool] '.($value ? 'TRUE' : 'FALSE').'</em>';
		}
		elseif (is_numeric($value))
		{
			$val_disp = '<em>[int] '.(string) $value.'</em>';
		}
		elseif(is_object($value))
		{
			if(method_exists($value, '__toString'))
			{
				$text = (string)$value;
			}
			$val_disp = '<em>[object] ' . get_class ($value). ' '  .$text.'</em>';
		}
		elseif(is_array($value))
		{
			$array_debug = '';
			if($level < 7)
			{
				foreach($value as $key => $val)
				{
					$print = true;
					if(is_numeric($key) && $key > 0)
					{
						$print = false;
					}
					if(is_numeric($key))
					{
						$key = '[0 .. '.count($value).']';
					}				
					if($print)
					{
						$array_debug.= self::debugVar($key, $val, $name, $level++);
					}
				}
			}
			$val_disp = '<em>array('.count($value).')</em> <ul>'.$array_debug.'</ul>';
		}
		else
		{
			if (!is_string($value))
			{
				$value = (string) $value;
			}
			$val_disp = '<em>&quot;' . htmlspecialchars($value) . '&quot;</em>';
		}

		return  '<li>{' . htmlspecialchars($name) . '} =&gt; ' . $val_disp . '</li>';
	}
	
	public function debug()
	{
			// Print debug stuff for current file
			if(!in_array($this->templateFile, self::$debug_data))
			{
				self::$debug_data[] = $this->templateFile;
				echo "<h1>".$this->templateFile."</h1>";
				echo "<ul>";
				foreach($this->vars as $key => $val)
				{
					echo self::debugVar($key, $val);
				}
				echo "</ul>";
				if(count($this->blockVars))
				{
					echo "<ul>";
					foreach($this->vars as $key => $val)
					{
						echo self::debugVar($key, $val);
					}
					echo "</ul>";
				}
			}
			/*foreach ($this->blockVars as $block => $tags) {
				$block_name = $file . ' / ' . str_replace('.', ' / ', $block);
				echo "<h2>$block_name</h2>";
				echo "<ul>";
				foreach ($tags as $key => $val)
				{
					if (is_array($val))
					{
						// One level of nesting is supported
						foreach ($val as $key2 => $val2)
						{
							echo self::debugVar($key . '.' . $key2, $val2);
						}
					}
					else
					{
						echo self::debugVar($key, $val);
					}
				}
				echo "</ul>";
			}*/		
	}	

	/**
	 * Returns parsed block HTML
	 *
	 * @param string $block Block name
	 * @return string
	 */	
	public function text($block = null)
	{
		if(self::$debug_mode && self::$debug_output)
		{
			$this->debug();
			return $this;
		}
		return self::$fenom->fetch($this->templateFile, $this->getVariables($block));
	}
	/**
	 * Prints a parsed block
	 *
	 * @param string $block Block name
	 * @return XTemplate $this object for call chaining
	 */	
	public function out($block = null)
	{
		if(self::$debug_mode && self::$debug_output)
		{
			return $this->debug();
		}
		return self::$fenom->display($this->templateFile, $this->getVariables($block));
	}
}
