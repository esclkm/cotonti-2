<?php

/**
 * @package install
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2009-2014
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
			$requires = empty($info['Requires']) ? '' : implode(', ', explode(',', $info['Requires']));
			$recommends = empty($info['Recommends']) ? '' : implode(', ', explode(',', $info['Recommends']));

			if (count($selected_list) > 0)
			{
				$checked = in_array($code, $selected_list);
			}
			else
			{
				$checked = in_array($code, $default_list);
			}
			$L['info_name'] = '';
			$L['info_desc'] = '';
			$icofile = $cfg['extensions_dir'].'/'.$code.'/'.$code.'.png';

			if (file_exists(cot_langfile($code)))
			{
				include cot_langfile($code);
			}
			$t->assign(array(
				"EXT_ROW_CHECKBOX" => cot_checkbox($checked, "install_extensions[$code]"),
				"EXT_ROW_TITLE" => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
				"EXT_ROW_DESCRIPTION" => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
				"EXT_ROW_ICO" => (file_exists($icofile)) ? $icofile : '',
				"EXT_ROW_REQUIRES" => $requires,
				"EXT_ROW_RECOMMENDS" => $recommends
			));
			$t->parse("MAIN.STEP_5.EXT_CAT.EXT_ROW");
		}
	}
	// Render last category
	$t->parse("MAIN.STEP_5.EXT_CAT");
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
			if ($prev_cat != $info['Category'])
			{
				if ($prev_cat != '')
				{
					// Render previous category
					$t->parse("MAIN.STEP_5.EXT_CAT");
				}
				// Assign a new one
				$prev_cat = $info['Category'];
				$t->assign('EXT_CAT_TITLE', $L['ext_cat_'.$info['Category']]);
			}
			$requires = empty($info['Requires']) ? '' : implode(', ', explode(',', $info['Requires']));
			$recommends = empty($info['Recommends']) ? '' : implode(', ', explode(',', $info['Recommends']));

			if (count($selected_list) > 0)
			{
				$checked = in_array($code, $selected_list);
			}
			else
			{
				$checked = in_array($code, $default_list);
			}
			$L['info_name'] = '';
			$L['info_desc'] = '';
			$icofile = $cfg['extensions_dir'].'/'.$code.'/'.$code.'.png';

			if (file_exists(cot_langfile($code)))
			{
				include cot_langfile($code);
			}
			$t->assign(array(
				"EXT_ROW_CHECKBOX" => cot_checkbox($checked, "install_extensions[$code]"),
				"EXT_ROW_TITLE" => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
				"EXT_ROW_DESCRIPTION" => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
				"EXT_ROW_ICO" => (file_exists($icofile)) ? $icofile : '',
				"EXT_ROW_REQUIRES" => $requires,
				"EXT_ROW_RECOMMENDS" => $recommends
			));
			$t->parse("MAIN.STEP_5.EXT_CAT.EXT_ROW");
		}
	}
	if ($prev_cat != '')
	{
		// Render last category
		$t->parse("MAIN.STEP_5.EXT_CAT");
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
