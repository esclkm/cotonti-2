<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.register.tags
Tags=users.register.tpl:{USERS_REGISTER_VERIFYIMG},{USERS_REGISTER_VERIFYINPUT}
[END_COT_EXT]
==================== */

/**
 * mCAPTCHA registration tags
 *
 * @package mcaptcha
 * @version 0.1.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['captchamain'] == 'mcaptcha')
{
	$t->assign(array(
		'USERS_REGISTER_VERIFYIMG' => cot_captcha_generate(),
		'USERS_REGISTER_VERIFYINPUT' => cot_inputbox('text', 'rverify', '', 'size="10" maxlength="20"'),
	));
}
