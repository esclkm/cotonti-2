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
class TemplateData implements ArrayAccess
{

	//добавляем новые методы
	private $block_vars = array();
	private $vars = array();
	
	public function __construct()
	{
		$this->vars = array();
	}
	
	public function offsetSet($key, $value)
	{
		$key = $value;
	}

	public function offsetUnset($key)
	{
		$key = 0;
	}

	public function offsetGet($key)
	{
		if($key == 'PHP')
		{
			return $_GLOBALS[$key];
		}
		elseif(isset($this->block_vars))
		{
			return $this->block_vars;
		}
		else
		{
			return $this->vars[$key];
		}
	}

	public function offsetExists($key)
	{
		return isset($this->block_vars[$key]);
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
		$vars_array = &$this->block_vars;
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
	
	public function text($block = null)
	{
		return false;
	}
	public function out($block = null)
	{
		//cot_print($this->vars, $this->block_vars);
		return array_merge($this->block_vars, $this->vars,  array('PHP' => &$GLOBALS));
	}
}
