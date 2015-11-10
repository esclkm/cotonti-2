<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=users.register.add.first
  [END_COT_EXT]
  ==================== */

/**
 * mCAPTCHA code check
 *
 * @package mcaptcha
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['captchamain'] == 'mcaptcha')
{
    $rverify = cot_import('rverify', 'P', 'INT');

    if (!cot_captcha_validate($rverify))
    {
        cot_error('captcha_verification_failed', 'rverify');
    }
}
