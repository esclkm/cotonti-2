<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Administration panel - PFS
 *
 * @package pfs
 * @version 0.1.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('pfs', 'a');
cot_block($usr['isadmin']);

require_once cot_incfile('pfs', 'functions');

if ($s == 'allpfs')
{
	require cot_incfile('pfs', 'admin.allpfs');
}
else
{
	$t = new XTemplate(cot_tplfile('pfs.admin'));

	$adminpath[] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
	$adminpath[] = array(cot_url('admin', 't=extensions&a=details&mod='.$m), $cot_extensions[$m]['title']);
	$adminpath[] = array(cot_url('admin', 't='.$m), $L['Administration']);
	$adminsubtitle = $L['pfs_title'];

	/* === Hook === */
	foreach (cot_getextensions('pfs.admin.first') as $ext)
	{
		include $ext;
	}
	/* ===== */

	if (!function_exists('gd_info'))
	{
		$is_adminwarnings = true;
	}
	else
	{
		$gd_datas = gd_info();
		foreach ($gd_datas as $k => $i)
		{
			if (mb_strlen($i) < 2)
			{
				$i = $cot_yesno[$i];
			}
			$t->assign(array(
				'ADMIN_PFS_DATAS_NAME' => $k,
				'ADMIN_PFS_DATAS_ENABLE_OR_DISABLE' => $i
			));
			$t->parse('MAIN.PFS_ROW');
		}
	}

	$t->assign(array(
		'ADMIN_PFS_URL_CONFIG' => cot_url('admin', 't=config&n=edit&o=extension&p=pfs'),
		'ADMIN_PFS_URL_ALLPFS' => cot_url('admin', 't=pfs&s=allpfs'),
		'ADMIN_PFS_URL_SFS' => cot_url('pfs', 'userid=0'),
		'ADMIN_PFS_BREADCRUMBS' => cot_breadcrumbs($adminpath, false),		
	));

	/* === Hook  === */
	foreach (cot_getextensions('pfs.admin.tags') as $ext)
	{
		include $ext;
	}
	/* ===== */
}

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
