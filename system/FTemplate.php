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
			'force_compile' => true
		);

		$options = array_merge($defaults, $options);
		$cache = $options['cache_dir'];
		unset($options['cache_dir']);
		
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
	 * Returns parsed block HTML
	 *
	 * @param string $block Block name
	 * @return string
	 */	
	public function text($block = null)
	{
		self::$fenom->fetch($this->templateFile, $this->getVariables($block));
	}
	/**
	 * Prints a parsed block
	 *
	 * @param string $block Block name
	 * @return XTemplate $this object for call chaining
	 */	
	public function out($block = null)
	{
		return self::$fenom->display($this->templateFile, $this->getVariables($block));
	}
}
