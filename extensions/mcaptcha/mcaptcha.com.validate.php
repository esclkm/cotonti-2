<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=comments.send.first
  [END_COT_EXT]
  ==================== */

/**
 * mCAPTCHA validation
 *
 * @package mcaptcha
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die("Wrong URL.");

if ($cfg['captchamain'] == 'mcaptcha' && $usr['id'] == '0')
{
	$rverify = cot_import('rverify', 'P', 'TXT');

	if (!cot_captcha_validate($rverify))
	{
		cot_error('captcha_verification_failed', 'rverify');
	}
}
