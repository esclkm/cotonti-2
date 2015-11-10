<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=header.main
  [END_COT_EXT]
  ==================== */

/**
 * Header notifications
 *
 * @package contact
 * @version 2.1.0
 * @author Feliz Team
 * @copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if (cot_auth('contact', 'any', 'A'))
{
	require_once cot_incfile('contact', 'functions');

	$new_contact = $db->query("SELECT COUNT(*) FROM $db_contact WHERE contact_val=0")->fetchColumn();
	$notify_contact = ($new_contact > 0) ? array(cot_url('admin', 't=other&p=contact'), cot_declension($new_contact, $Ls['contact_headercontact'])) : '';
	if (!empty($notify_contact))
	{
		$out['notices_array'][] = $notify_contact;
	}
}
