<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Avatar and photo for users
 *
 * @package userimages
 * @version 1.1
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('users', 'a');
cot_block($usr['isadmin']);

$tt = new XTemplate(cot_tplfile('userimages.admin'));
require_once cot_incfile('userimages');
require_once cot_incfile('userimages', 'resources');
require_once cot_langfile('userimages');
require_once cot_incfile('system', 'configuration');

$adminsubtitle = $L['userimages_title'];

/* === Hook === */
foreach (cot_getextensions('userimages.admin.first') as $ext)
{
	include $ext;
}
/* ===== */

if($a == 'add')
{
	$code = cot_import('userimg_code', 'P', 'ALP');
	$width = cot_import('userimg_width', 'P', 'INT');
	$height = cot_import('userimg_height', 'P', 'INT');
	$crop = cot_import('userimg_crop', 'P', 'TXT');
	if (!cot_userimages_config_add($code, $width, $height, $crop))
	{
		cot_error('userimages_emptycode', 'userimg_code');
	}
	cot_redirect(cot_url('admin', 't=other&p=userimages', '', true));
}
if($a == 'edit')
{
	$code = cot_import('code', 'G', 'ALP');
	$width = cot_import('userimg_width', 'P', 'INT');
	$height = cot_import('userimg_height', 'P', 'INT');
	$crop = cot_import('userimg_crop', 'P', 'TXT');
	if (!cot_userimages_config_edit($code, $width, $height, $crop))
	{
		cot_error('userimages_emptycode', 'code');
	}
	cot_redirect(cot_url('admin', 't=other&p=userimages', '', true));
}
if($a == 'remove')
{
	$code = cot_import('code', 'G', 'ALP');
	if (!cot_userimages_config_remove($code))
	{
		cot_error('userimages_emptycode');
	}
	cot_redirect(cot_url('admin', 't=other&p=userimages', '', true));
}

$userimg = cot_userimages_config_get(true);
foreach($userimg as $code => $settings)
{
	$tt->assign(array(
		'CODE' => $code,
		'WIDTH' => $settings['width'],
		'HEIGHT' => $settings['height'],
		'CROP' => $settings['crop'],
		'EDIT_URL' => cot_url('admin', 't=other&p=userimages&a=edit&code='.$code),
		'REMOVE' => cot_rc('userimg_remove', array('url' => cot_url('admin', 't=other&p=userimages&a=remove&code='.$code)))
	));
	$tt->parse('MAIN.USERIMG_LIST');
}
$tt->assign(array(
	'ADMIN_USERIMAGES_BREADCRUMBS' =>  cot_breadcrumbs($out['breadcrumbs'], false)
));
cot_display_messages($tt); // use cot_message()

/* === Hook  === */
foreach (cot_getextensions('userimages.admin.tags') as $ext)
{
	include $ext;
}
/* ===== */

$tt->parse('MAIN');
$adminmain = $tt->text('MAIN');
