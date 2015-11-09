<?php
/**
 * System messages and redirect proxy
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

define('COT_CODE', TRUE);
define('COT_MESSAGE', TRUE);
define('COT_CORE', TRUE);
require_once './datas/config.php';
require_once $cfg['system_dir'] . '/functions.php';

$env['location'] = 'messages';
$env['ext'] = 'message';

require_once $cfg['system_dir'] . '/cotemplate.php';
require_once $cfg['system_dir'] . '/common.php';

// This trick allows message strings to be overriden in theme langfiles
$temp_L = $L;
require_once cot_langfile('message', 'system');
$L = array_merge($L, $temp_L);
unset($temp_L);

if (defined('COT_ADMIN'))
{
	require_once cot_incfile('admin');
}

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('message', 'a');
//cot_block($usr['auth_read']);

$msg = cot_import('msg', 'G', 'INT');
$num = cot_import('num', 'G', 'INT');
$rc = cot_import('rc', 'G', 'INT');

unset($r, $rd, $ru);

$title = $L['msg' . $msg . '_title'];
$body = $L['msg' . $msg . '_body'];

/* === Hook === */
foreach (cot_getextensions('message.first') as $ext)
{
	include $ext;
}
/* ===== */

switch ($msg)
{
	/* ======== Users ======== */

	case '100':
		$rd = 2;
		$ru = cot_url('login', (empty($redirect) ? '' : "redirect=$redirect"));
		break;

	case '102':
		$r = 1;
		$rd = 2;
		break;

	case '153':
		if ($num > 0)
		{
			$body .= cot_rc('msg_code_153_date', array('date' => cot_date('datetime_medium', $num)));
		}
		break;

	/* ======== Error Pages ========= */

	case '400':
	case '401':
	case '403':
	case '404':
	case '500':
		$rd = 5;
		$ru = empty($redirect) ? '' : str_replace('&', '&amp;', base64_decode($redirect));
		break;

	/* ======== System messages ======== */

	case '916':
		$rd = 2;
		$ru = cot_url('admin');
		break;

	case '920':
		if (!empty($m))
		{
			// Load extension langfile
			if (file_exists(cot_langfile($m)))
			{
				include cot_langfile($m);
			}
		}
		$lng = cot_import('lng', 'G', 'ALP');
		if (!empty($lng))
		{
			// Assign custom message
			if (isset($L[$lng]))
			{
				$body = $L[$lng];
			}
		}
		$rc = '920';
		break;

	case '930':
		if ($usr['id'] > 0)
		{
			break;
		}
		$rd = 2;
		if (!empty($redirect))
		{
			$uri_redirect = base64_decode($redirect);
			if (mb_strpos($uri_redirect, '&x=') !== false || mb_strpos($uri_redirect, '?x=') !== false)
			{
				// xg, not redirect to form action/GET or to command from GET
				break;
			}
		}
		$ru = cot_url('login', (empty($redirect) ? '' : "redirect=$redirect"));
		break;
}

/* ============= */
if (empty($title) || empty($body))
{
	$title = $L['msg950_title'];
	$body = $L['msg950_body'];
	unset($rc, $rd);
}
if (empty($rc) && empty($rd))
{
	$rd = '5';
}

switch ($rc)
{
	case '100':
		$r['100'] = cot_url('admin', 't=extensions');
		break;

	case '101':
		$r['101'] = cot_url('admin', 't=hitsperday');
		break;

	case '102':
		$r['102'] = cot_url('admin', 't=polls');
		break;

	case '103':
		$r['103'] = cot_url('admin', 't=forums');
		break;

	case '200':
		$r['200'] = cot_url('users');
		break;

	default:
		$rc = '';
		break;
}

if ($rc != '')
{
	if (mb_strpos($r["$rc"], '://') === false)
	{
		$r["$rc"] = COT_ABSOLUTE_URL . $r["$rc"];
	}
	$out['head'] .= cot_rc('msg_code_redir_head', array('delay' => 2, 'url' => $r["$rc"]));
	$body .= $R['code_error_separator'] . $L['msgredir'];
}
elseif ($rd != '')
{
	if (mb_strpos($ru, '://') === false)
	{
		$ru = COT_ABSOLUTE_URL . ltrim($ru, '/');
	}
	$out['head'] .= cot_rc('msg_code_redir_head', array('delay' => $rd, 'url' => $ru));
	$body .= $R['code_error_separator'] . $L['msgredir'];
}

/* === Hook === */
foreach (cot_getextensions('message.main') as $ext)
{
	include $ext;
}
/* ===== */

$out['head'] .= $R['code_noindex'];
$out['subtitle'] = $title;
require_once $cfg['system_dir'] . '/header.php';

$t = new FTemplate(cot_tplfile('message', 'system'));

$t->assign(array(
	'MESSAGE_ERROR_CODE' => $msg,
	'MESSAGE_TITLE' => $title,
	'MESSAGE_BODY' => $body,
	'AJAX_MODE' => COT_AJAX
));

if ($msg == '920')
{
	$confirm_no_url = preg_match("/^.+".preg_quote($sys['domain']."/"), $_SERVER['HTTP_REFERER']) ? str_replace('&', '&amp;', $_SERVER['HTTP_REFERER']) : cot_url('index');

	if (preg_match('#[ "\':]#', base64_decode($redirect)))
	{
		$redirect = '';
	}

	$t->assign(array(
		'MESSAGE_CONFIRM_YES' => base64_decode($redirect),
		'MESSAGE_CONFIRM_NO' => $confirm_no_url,
		'MESSAGE_CONFIRM' => 1
	));
}

/* === Hook === */
foreach (cot_getextensions('message.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->out();

require_once $cfg['system_dir'] . '/footer.php';
