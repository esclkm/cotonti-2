<?php
/**
 * AutoAlias functions
 *
 * @package autoalias2
 * @version 2.1.2
 * @author Trustmaster
 * @copyright (c) Cotonti Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('page');

/**
 * Converts a title into an alias
 *
 * @param string $title Title
 * @param int $id Page ID
 * @param bool $duplicate TRUE if duplicate alias was previously detected
 * @return string
 */
function autoalias2_convert($title, $id = 0, $duplicate = false)
{
	global $cfg, $cot_translit, $cot_translit_custom;

	if($cfg['autoalias2']['translit'] && file_exists(cot_langfile('translit', 'core')))
	{
		include cot_langfile('translit', 'core');
		if (is_array($cot_translit_custom))
		{
			$title = strtr($title, $cot_translit_custom);
		}
		elseif (is_array($cot_translit))
		{
			$title = strtr($title, $cot_translit);
		}
	}
	$title = preg_replace('#[^\p{L}0-9\-_ ]#u', '', $title);
	$title = str_replace(' ', $cfg['autoalias2']['sep'], $title);

	if ($cfg['autoalias2']['lowercase'])
	{
		$title = mb_strtolower($title);
	}

	if ($cfg['autoalias2']['prepend_id'] && !empty($id))
	{
		$title = $id . $cfg['autoalias2']['sep'] . $title;
	}
	elseif ($duplicate)
	{
		switch ($cfg['autoalias2']['on_duplicate'])
		{
			case 'ID':
				if (!empty($id))
				{
					$title .= $cfg['autoalias2']['sep'] . $id;
					break;
				}
			default:
				$title .= $cfg['autoalias2']['sep'] . rand(2, 99);
				break;
		}
	}

	return $title;
}

/**
 * Updates an alias for a specific page
 *
 * @param string $title Page title
 * @param int $id Page ID
 */
function autoalias2_update($title, $id)
{
	global $cfg, $db, $db_pages;
	$duplicate = false;
	do
	{
		$alias = autoalias2_convert($title, $id, $duplicate);
		if (!$cfg['autoalias2']['prepend_id']
			&& $db->query("SELECT COUNT(*) FROM $db_pages
				WHERE page_alias = '$alias' AND page_id != $id")->fetchColumn() > 0)
		{
			$duplicate = true;
		}
		else
		{
			$db->update($db_pages, array('page_alias' => $alias), "page_id = $id");
			$duplicate = false;
		}
	}
	while ($duplicate && !$cfg['autoalias2']['prepend_id']);
	return $alias;
}
