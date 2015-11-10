<?php
/**
 * Extension administration
 *
 * @package Feliz
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
cot_block($usr['isadmin']);

require_once cot_incfile('system', 'auth');

$t = new XTemplate(cot_tplfile('admin.extensions', 'system'));

$out['breadcrumbs'][] = array (cot_url('admin', 't=extensions'), $L['Extensions']);
$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions&m=hooks'), $L['Hooks']);

$adminsubtitle = $L['Extensions'];

$part = cot_import('part', 'G', 'TXT');
$sort = cot_import('sort', 'G', 'ALP');

if (empty($e))
{
	if (!empty($m) && $m != 'hooks')
	{
		cot_die();
	}
}

/* === Hook === */
foreach (cot_getextensions('admin.extensions.first') as $ext)
{
	include $ext;
}
/* ===== */

$sql = $db->query("SELECT * FROM $db_extension_hooks ORDER BY ext_hook ASC, ext_code ASC, ext_order ASC");

while($row = $sql->fetch())
{
	$t->assign(array(
		'ADMIN_EXTENSIONS_HOOK' => $row['ext_hook'],
		'ADMIN_EXTENSIONS_CODE' => $row['ext_code'],
		'ADMIN_EXTENSIONS_ORDER' => $row['ext_order'],
		'ADMIN_EXTENSIONS_ACTIVE' => $cot_yesno[$row['ext_active']]
	));
	$t->parse('MAIN.HOOKS_ROW');
}
$sql->closeCursor();

$t->assign(array(
	'ADMIN_EXTENSIONS_CNT_HOOK' => $sql->rowCount()
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.extensions.tags') as $ext)
{
	include $ext;
}
/* ===== */
$t->parse('MAIN');
$adminmain = $t->text('MAIN');
