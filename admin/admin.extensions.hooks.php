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

$out['breadcrumbs'][] = array (cot_url('admin', 't=extensions'), $L['Extensions']);
$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions&m=hooks'), $L['Hooks']);

$adminsubtitle = $L['Extensions'];


/* === Hook === */
foreach (cot_getextensions('admin.extensions.first') as $ext)
{
	include $ext;
}
/* ===== */
$t = new FTemplate(cot_tplfile('admin.extensions.hooks', 'system'));
$sql = $db->query("SELECT * FROM $db_extension_hooks ORDER BY ext_hook ASC, ext_code ASC, ext_order ASC");

$hooks = array();
while($row = $sql->fetch())
{
	$hooks[] =[
		'HOOK' => $row['ext_hook'],
		'CODE' => $row['ext_code'],
		'ORDER' => $row['ext_order'],
		'ACTIVE' => $cot_yesno[$row['ext_active']]
	];
}

$sql->closeCursor();

$t->assign(array(
	'ADMIN_EXT_HOOKS' => $hooks,
	'ADMIN_EXT_CNT_HOOK' => $sql->rowCount()
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
