<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=admin.extrafields.first
  [END_COT_EXT]
  ==================== */

/**
 * Contact Plugin for Cotonti CMF
 *
 * @package contact
 * @version 2.1.0
 * @author Cotonti Team
 * @copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('contact', 'module');

$extra_whitelist[$db_contact] = array(
	'name' => $db_contact,
	'caption' => $L['Plugin'].' Contact',
	'type' => 'module',
	'code' => 'contact',
	'tags' => array(
		'contact.tools.tpl' => '{CONTACT_XXXXX}, {CONTACT_XXXXX_TITLE}',
		'contact.tpl' => '{CONTACT_FORM_XXXXX}, {CONTACT_FORM_XXXXX_TITLE}',
	)
);
