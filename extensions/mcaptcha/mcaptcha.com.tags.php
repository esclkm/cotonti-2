<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=comments.newcomment.tags
Tags=comments.tpl: {COMMENTS_FORM_VERIFY_IMG}, {COMMENTS_FORM_VERIFY}
[END_COT_EXT]
==================== */

/**
 * mCAPTCHA functions
 *
 * @package mcaptcha
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die("Wrong URL.");

if ($usr['id'] == '0' && $cfg['captchamain'] == 'mcaptcha')
{
	$t->assign(array(
		'COMMENTS_FORM_VERIFYIMG' => cot_captcha_generate(),
		'COMMENTS_FORM_VERIFY' => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20"'),
	));
}
