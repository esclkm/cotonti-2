<?php

/**
 * @package install
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2009-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

/**
 * Replaces a sample config with its actual value
 *
 * @param string $file_contents Config file contents
 * @param string $config_name Config option name
 * @param string $config_value Config value to set
 * @return string Modified file contents
 */
function cot_install_config_replace(&$file_contents, $config_name, $config_value)
{
	$file_contents = preg_replace("#^\\\$cfg\['$config_name'\]\s*=\s*'.*?';#m", "\$cfg['$config_name'] = '$config_value';", $file_contents);
}

/**
 * Parses extensions selection section
 *
 * @param array $default_list A list of recommended extensions (checked by default)
 * @param array $selected_list A list of previously selected extensions
 */
function cot_install_parse_extensions_alpha($default_list = array(), $selected_list = array())
{
	global $t, $cfg, $L;

	$ext_list = cot_extension_list_info($cfg["extensions_dir"]);

	uasort($ext_list, 'cot_extension_namecmp');

	$prev_cat = '';
	foreach ($ext_list as $f => $info)
	{
		if (is_array($info))
		{
			$code = $f;
			$checked = in_array($code, (count($selected_list) > 0) ? $selected_list : $default_list);
			
			$L['info_name'] = '';
			$L['info_desc'] = '';
			$icofile = $cfg['extensions_dir'].'/'.$code.'/'.$code.'.png';

			if (file_exists(cot_langfile($code)))
			{
				include cot_langfile($code);
			}
			$cats['all'] = '';
			$ext['all'][] = array(
				"CHECKBOX" => cot_checkbox($checked, "install_extensions[$code]"),
				"TITLE" => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
				"ESCRIPTION" => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
				"ICO" => (file_exists($icofile)) ? $icofile : '',
				"REQUIRES" => array_filter(explode(',', $info['Requires'])),
				"RECOMMENDS" => array_filter(explode(',', $info['Recommends']))
			);
			$t->assign("INSTALL_CATEGORIES", $cats);
			$t->assign("INSTALL_EXTENSIONS", $ext);
		}
	}
}

/**
 * Parses extensions selection section
 *
 * @param array $default_list A list of recommended extensions (checked by default)
 * @param array $selected_list A list of previously selected extensions
 */
function cot_install_parse_extensions($default_list = array(), $selected_list = array())
{
	global $t, $cfg, $L;

	$ext_list = cot_extension_list_info($cfg["extensions_dir"]);

	uasort($ext_list, 'cot_extension_catcmp');

	$prev_cat = '';
	foreach ($ext_list as $f => $info)
	{
		if (is_array($info))
		{
			$code = $f;
			$checked = in_array($code, (count($selected_list) > 0) ? $selected_list : $default_list);

			$L['info_name'] = '';
			$L['info_desc'] = '';
			$icofile = $cfg['extensions_dir'].'/'.$code.'/'.$code.'.png';

			if (file_exists(cot_langfile($code)))
			{
				include cot_langfile($code);
			}

			$cats[$info['Category']] = empty($L['ext_cat_'.$info['Category']]) ? $info['Category'] : $L['ext_cat_'.$info['Category']];
			$ext[$info['Category']][] = array(
				"CHECKBOX" => cot_checkbox($checked, "install_extensions[$code]"),
				"TITLE" => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
				"ESCRIPTION" => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
				"ICO" => (file_exists($icofile)) ? $icofile : '',
				"REQUIRES" => array_filter(explode(',', $info['Requires'])),
				"RECOMMENDS" => array_filter(explode(',', $info['Recommends']))
			);
			$t->assign("INSTALL_CATEGORIES", $cats);
			$t->assign("INSTALL_EXTENSIONS", $ext);
		}
	}
}

/**
 * Sorts selected extensions by their setup order if present
 *
 * @global array $cfg
 * @param array $selected_extensions Unsorted list of extension names

 * @return array Sorted list of extension names
 */
function cot_install_sort_extensions($selected_extensions)
{
	global $cfg;

	$ret = array();

	// Split into groups by Order value
	$extensions = array();
	foreach ($selected_extensions as $name)
	{
		$info = cot_infoget($cfg['extensions_dir']."/$name/$name.setup.php", 'COT_EXT');
		$order = isset($info['Order']) ? (int)$info['Order'] : COT_EXT_DEFAULT_ORDER;
		if ($info['Category'] == 'post-install' && $order < 999)
		{
			$order = 999;
		}
		$extensions[$order][] = $name;
	}

	// Merge back into a single array
	foreach ($extensions as $grp)
	{
		foreach ($grp as $name)
		{
			$ret[] = $name;
		}
	}

	return $ret;
}
