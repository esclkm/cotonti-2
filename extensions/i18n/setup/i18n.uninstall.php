<?php
/**
 * Uninstallation handler
 *
 * @package i18n
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if (cot_extension_active('tags'))
{
	// Remove i18n-specific tags
	require_once cot_incfile('tags', 'functions');
	global $db_tag_references;
	$db->delete($db_tag_references, "tag_locale != ''");
	$db->query("ALTER TABLE $db_tag_references DROP PRIMARY KEY");
	$db->query("ALTER TABLE $db_tag_references ADD PRIMARY KEY (`tag`,`tag_area`,`tag_item`)");
	$db->query("ALTER TABLE $db_tag_references DROP COLUMN `tag_locale`");
}
