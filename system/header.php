<?php
/**
 * Global header
 *
 * @package Feliz
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

cot_uriredir_store();

/* === Hook === */
foreach (cot_getextensions('header.first') as $ext)
{
	include $ext;
}
/* ===== */

$out['logstatus'] = ($usr['id'] > 0) ? $L['hea_youareloggedas'].' '.$usr['name'] : $L['hea_youarenotlogged'];
$out['userlist'] = (cot_auth('users', 'a', 'R')) ? cot_rc_link(cot_url('users'), $L['Users']) : '';

unset($title_tags, $title_data);

if (is_numeric($pg) && $pg > 1)
{
	// Append page number to subtitle
	$out['subtitle'] .= cot_rc('code_title_page_num', array('num' => $pg));
}

$title_params = array(
	'MAINTITLE' => $cfg['maintitle'],
	'DESCRIPTION' => $cfg['subtitle'],
	'SUBTITLE' => $out['subtitle']
);
if (defined('COT_INDEX'))
{
	$out['fulltitle'] = cot_title('title_header_index', $title_params);
}
else
{
	$out['fulltitle'] = cot_title('title_header', $title_params);
}

$out['meta_contenttype'] = $cfg['xmlclient'] ? 'application/xml' : 'text/html';
$out['basehref'] = $R['code_basehref'];
$out['meta_charset'] = 'UTF-8';
$out['meta_desc'] = empty($out['desc']) ? $cfg['subtitle'] : htmlspecialchars($out['desc']);
$out['meta_keywords'] = empty($out['keywords']) ? $cfg['metakeywords'] : htmlspecialchars($out['keywords']);
$out['meta_lastmod'] = gmdate('D, d M Y H:i:s');
$out['head_head'] .= $out['head'];

cot_rc_output();
if ($cfg['jquery'] && $cfg['jquery_cdn'])
{
	cot_rc_link_file($cfg['jquery_cdn'], true);
}

if ($sys['noindex'])
{
	$out['head_head'] .= $R['code_noindex'];
}
if(!headers_sent())
{
	cot_sendheaders($out['meta_contenttype'], isset($env['status']) ? $env['status'] : '200 OK', $env['last_modified']);
}
if (!COT_AJAX)
{
	if ($cfg['enablecustomhf'])
	{
		$mtpl_base = array('header', $e);
	}
	else
	{
		$mtpl_base = 'header';
	}

	/* === Hook === */
	foreach (cot_getextensions('header.main') as $ext)
	{
		include $ext;
	}
	/* ===== */

	if(is_array($out['notices_array']))
	{
		foreach ($out['notices_array'] as $notice)
		{
			$notice = (is_array($notice)) ? cot_rc_link($notice[0], $notice[1]) : $notice;
			$out['notices'] .= ((!empty($out_notices)) ? ', ' : '').$notice;
		}
	}
	$out['canonical_uri'] = empty($out['canonical_uri']) ? str_replace('&', '&amp;', $sys['canonical_url']) : $out['canonical_uri'];
	if(!preg_match("#^https?://.+#", $out['canonical_uri']))
	{
		$out['canonical_uri'] = COT_ABSOLUTE_URL . $out['canonical_uri'];
	}
	$t = new FTemplate(cot_tplfile($mtpl_base, 'system'));
	$t->assign(array(
		'HEADER_TITLE' => $out['fulltitle'],
		'HEADER_COMPOPUP' => $out['compopup'],
		'HEADER_LOGSTATUS' => $out['logstatus'],
		'HEADER_TOPLINE' => $cfg['topline'],
		'HEADER_BANNER' => $cfg['banner'],
		'HEADER_GMTTIME' => $usr['gmttime'],
		'HEADER_USERLIST' => $out['userlist'],
		'HEADER_NOTICES' => $out['notices'],
		'HEADER_NOTICES_ARRAY' => $out['notices_array'],
		'HEADER_BASEHREF' => $out['basehref'],
		'HEADER_META_CONTENTTYPE' => $out['meta_contenttype'],
		'HEADER_META_CHARSET' => $out['meta_charset'],
		'HEADER_META_DESCRIPTION' => $out['meta_desc'],
		'HEADER_META_KEYWORDS' => $out['meta_keywords'],
		'HEADER_META_LASTMODIFIED' => $out['meta_lastmod'],
		'HEADER_HEAD' => $out['head_head'],
		'HEADER_CANONICAL_URL' => $out['canonical_uri'],
		'HEADER_PREV_URL' => $out['prev_uri'],
		'HEADER_NEXT_URL' => $out['next_uri'],
		'HEADER_BREADCRUMBS' => cot_breadcrumbs($out['breadcrumbs'], false),
		'HEADER_COLOR_SCHEME' => cot_schemefile()
	));

	if ($usr['id'] > 0)
	{
		$out['adminpanel'] = (cot_auth('admin', 'any', 'R')) ? cot_rc_link(cot_url('admin'), $L['Administration']) : '';
		$out['loginout_url'] = cot_url('login', 'out=1&' . cot_xg());
		$out['loginout'] = cot_rc_link($out['loginout_url'], $L['Logout']);
		$out['profile'] = cot_rc_link(cot_url('users', 'm=profile'), $L['Profile']);

		$t->assign(array(
			'HEADER_USER' => 1,
			'HEADER_USER_NAME' => $usr['name'],
			'HEADER_USER_ADMINPANEL' => $out['adminpanel'],
			'HEADER_USER_ADMINPANEL_URL' => cot_url('admin'),
			'HEADER_USER_LOGINOUT' => $out['loginout'],
			'HEADER_USER_LOGINOUT_URL' => $out['loginout_url'],
			'HEADER_USER_PROFILE' => $out['profile'],
			'HEADER_USER_PROFILE_URL' => cot_url('users', 'm=profile'),
			'HEADER_USER_MESSAGES' => $usr['messages']
		));

	}
	else
	{
		$out['guest_username'] = $R['form_guest_username'];
		$out['guest_password'] = $R['form_guest_password'];
		$out['guest_register'] = cot_rc_link(cot_url('users', 'm=register'), $L['Register']);
		$out['guest_cookiettl'] = $cfg['forcerememberme'] ? $R['form_guest_remember_forced']
			: $R['form_guest_remember'];

		$t->assign(array (
			'HEADER_GUEST' => 1,
			'HEADER_GUEST_SEND' => cot_url('login', 'a=check&' . $sys['url_redirect']),
			'HEADER_GUEST_USERNAME' => $out['guest_username'],
			'HEADER_GUEST_PASSWORD' => $out['guest_password'],
			'HEADER_GUEST_REGISTER' => $out['guest_register'],
			'HEADER_GUEST_REGISTER_URL' => cot_url('users', 'm=register'),
			'HEADER_GUEST_COOKIETTL' => $out['guest_cookiettl']
		));
	}

	/* === Hook === */
	foreach (cot_getextensions('header.tags') as $ext)
	{
		include $ext;
	}
	/* ===== */

	$t->out();
}
define('COT_HEADER_COMPLETE', TRUE);
