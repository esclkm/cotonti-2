<?php

/**
 * Administration panel - Home page for administrators
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

$t = new XTemplate(cot_tplfile('admin.home', 'system'));

if (!$cfg['debug_mode'] && file_exists('install.php') && is_writable('datas/config.php'))
{
	cot_error('home_installable_error');
}

$adminsubtitle = ''; // Empty means just "Administration"

//Version Checking
if ($cfg['check_updates'] && $cache)
{
	$update_info = $cache->db->get('update_info');
	if (!$update_info)
	{
		if (ini_get('allow_url_fopen'))
		{
			$update_info = @file_get_contents('http://www.cotonti.com/update-check');
			if ($update_info)
			{
				$update_info = json_decode($update_info, TRUE);
				$cache->db->store('update_info', $update_info, COT_DEFAULT_REALM, 86400);
			}
		}
		elseif (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'http://www.cotonti.com/update-check');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			$update_info = curl_exec($curl);
			if ($update_info)
			{
				$update_info = json_decode($update_info, TRUE);
				$cache->db->store('update_info', $update_info, COT_DEFAULT_REALM, 86400);
			}
			curl_close($curl);
		}
	}
	if ($update_info['update_ver'] > $cfg['version'])
	{
		$t->assign(array(
			'ADMIN_HOME_UPDATE_REVISION' => sprintf($L['home_update_revision'], $cfg['version'], htmlspecialchars($update_info['update_ver'])),
			'ADMIN_HOME_UPDATE_MESSAGE' => cot_parse($update_info['update_message']),
		));
		$t->parse('MAIN.UPDATE');
	}
}

$target = array();

function cot_admin_other_cmp($ext_a, $ext_b)
{
	if($ext_a['ext_code'] == $ext_b['ext_code'])
	{
		return 0;
	}
	return ($ext_a['ext_code'] < $ext_b['ext_code']) ? -1 : 1;
}

$target = $cot_hooks['admin'];
$title = $L['Extensions'];

if (is_array($target))
{
	usort($target, 'cot_admin_other_cmp');
	foreach ($target as $ext)
	{
		$ext_info = cot_get_extensionparams($ext['ext_code']);
		$t->assign(array(
			'ADMIN_OTHER_EXT_URL' => cot_url('admin', 't=' . $ext['ext_code']),
			'ADMIN_OTHER_EXT_ICO' => $ext_info['icon'],
			'ADMIN_OTHER_EXT_NAME' => $ext_info['name'],
			'ADMIN_OTHER_EXT_DESC' => $ext_info['desc']
		));
		$t->parse('MAIN.SECTION.ROW');
	}
}
else
{
	$t->parse('MAIN.SECTION.EMPTY');
}
$t->assign('ADMIN_OTHER_SECTION', $title);
$t->parse('MAIN.SECTION');


$sql = $db->query("SHOW TABLES");
foreach ($sql->fetchAll(PDO::FETCH_NUM) as $row)
{
	$table_name = $row[0];
	$status = $db->query("SHOW TABLE STATUS LIKE '$table_name'");
	$status1 = $status->fetch();
	$status->closeCursor();
	$tables[] = $status1;
}

foreach ($tables as $dat)
{
	$table_length = $dat['Index_length'] + $dat['Data_length'];
	$total_length += $table_length;
	$total_rows += $dat['Rows'];
	$total_index_length += $dat['Index_length'];
	$total_data_length += $dat['Data_length'];
}

$totalextensions = $db->query("SELECT DISTINCT(ext_code) FROM $db_extension_hooks WHERE 1 GROUP BY ext_code")->rowCount();
$totalhooks = $db->query("SELECT COUNT(*) FROM $db_extension_hooks")->fetchColumn();

$t->assign(array(
	'ADMIN_HOME_DB_TOTAL_ROWS' => $total_rows,
	'ADMIN_HOME_DB_INDEXSIZE' => number_format(($total_index_length / 1024), 1, '.', ' '),
	'ADMIN_HOME_DB_DATASSIZE' => number_format(($total_data_length / 1024), 1, '.', ' '),
	'ADMIN_HOME_DB_TOTALSIZE' => number_format(($total_length / 1024), 1, '.', ' '),
	'ADMIN_HOME_TOTALEXTENSIONS' => $totalextensions,
	'ADMIN_HOME_TOTALHOOKS' => $totalhooks,
	'ADMIN_HOME_VERSION' => $cfg['version'],
	'ADMIN_HOME_DB_VERSION' => htmlspecialchars($db->query("SELECT upd_value FROM $db_updates WHERE upd_param = 'revision'")->fetchColumn())
));


/* === Hook === */
foreach (cot_getextensions('admin.home.mainpanel', 'R') as $ext)
{
	$line = '';
	include $ext;
	if (!empty($line))
	{
		$t->assign('ADMIN_HOME_MAINPANEL', $line);
		$t->parse('MAIN.MAINPANEL');
	}
}
/* ===== */

/* === Hook === */
foreach (cot_getextensions('admin.home.sidepanel', 'R') as $ext)
{
	$line = '';
	include $ext;
	if (!empty($line))
	{
		$t->assign('ADMIN_HOME_SIDEPANEL', $line);
		$t->parse('MAIN.SIDEPANEL');
	}
}
/* ===== */

/* === Hook === */
foreach (cot_getextensions('admin.home', 'R') as $ext)
{
	include $ext;
}
/* ===== */

cot_display_messages($t);

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
