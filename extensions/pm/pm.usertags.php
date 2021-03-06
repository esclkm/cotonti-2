<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=usertags.main
[END_COT_EXT]
==================== */

/**
 * PM user tags
 *
 * @package pm
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

global $L, $Ls, $R;
require_once cot_incfile('pm', 'functions');

if ($user_data['user_id'] > 0)
{
	$temp_array['PM'] = cot_build_pm($user_data['user_id']);
	$temp_array['PMNOTIFY'] = $cot_yesno[$user_data['user_pmnotify']];
}
else
{
	$temp_array['PM'] = '';
	$temp_array['PMNOTIFY'] = '';
}
