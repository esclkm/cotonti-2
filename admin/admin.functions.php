<?php
/**
 * Admin function library.
 *
 * @package Feliz
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL.');

// Requirements
require_once cot_incfile('system', 'extrafields');
require_once cot_incfile('system', 'forms');
require_once cot_incfile('system', 'extensions');

/* ======== Defaulting the admin variables ========= */

unset($adminmain, $adminhelp, $admin_icon);

/**
 * Returns $url as an HTML link if $cond is TRUE or just plain $text otherwise
 * @param string $url Link URL
 * @param string $text Link text
 * @param bool $cond Condition
 * @return string
 */
function cot_linkif($url, $text, $cond)
{
	if ($cond)
	{
		$res = '<a href="'.$url.'">'.$text.'</a>';
	}
	else
	{
		$res = $text;
	}

	return $res;
}

/**
 * Returns group selection dropdown code
 *
 * @param string $check Seleced value
 * @param string $name Dropdown name
 * @param array $skip Hidden groups
 * @return string
 */
function cot_selectbox_groups($check, $name, $skip=array(0))
{
	global $cot_groups;

	$res = "<select name=\"$name\" size=\"1\">";

	foreach($cot_groups as $k => $i)
	{
		if (!$i['skiprights'])
		{
			$selected = ($k == $check) ? "selected=\"selected\"" : '';
			$res .= (in_array($k, $skip)) ? '' : "<option value=\"$k\" $selected>".$cot_groups[$k]['name']."</option>";
		}
	}
	$res .= "</select>";

	return $res;
}

/**
* Returns a list of time zone names used for setting default time zone
*/
function cot_config_timezones()
{
	global $L;
	$timezonelist = cot_timezone_list(true, false);
	foreach($timezonelist as $timezone)
	{
		$names[] = $timezone['identifier'];
		$titles[] = $timezone['description'];
	}
	$L['cfg_defaulttimezone_params'] = $titles;
	return $names;
}

/**
 * Returns substring position in file
 *
 * @param string $file File path
 * @param string $str Needle
 * @param int $maxsize Search limit
 * @return int
 */
function cot_stringinfile($file, $str, $maxsize=32768)
{
	if ($fp = @fopen($file, 'r'))
	{
		$data = fread($fp, $maxsize);
		$pos = mb_strpos($data, $str);
		$result = !($pos === FALSE);
	}
	else
	{
		$result = FALSE;
	}
	@fclose($fp);
	return $result;
}

function cot_get_extensionparams($code)
{
	global $cfg, $cot_extensions, $cot_extensions;

	$name = $cot_extensions[$code]['title'];

	if(empty($name))
	{
		$ext_info = $cfg['extensions_dir'] . '/' . $code . '/' . $code . '.setup.php';
		$exists = file_exists($ext_info);
		if ($exists)
		{
			$info = cot_infoget($ext_info, 'COT_EXT');
			$name = $info['Name'];
			$desc = $info['Desc'];
		}
		else
		{
			$info = array(
				'Name' => $code
			);
		}
		$name = $info['Name'];
	}
	$icofile = $cfg['extensions_dir'] . '/' . $code . '/' . $code . '.png';
	$icon = file_exists($icofile) ? $icofile : '';

	$langfile = cot_langfile($code);
	if (file_exists($langfile))
	{
		include $langfile;
		if (!empty($L['info_name'])) $name = $L['info_name'];
		if (!empty($L['info_desc'])) $desc = $L['info_desc'];
	}

	return array(
		'name' => htmlspecialchars($name),
		'desc' => $desc,
		'icon' => $icon
	);
}
