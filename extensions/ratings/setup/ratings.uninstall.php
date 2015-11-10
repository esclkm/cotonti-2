<?php
/**
 * Removes all implanted configs
 *
 * @package ratings
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db, $db_config;
$db->delete($db_config, "config_donor = 'ratings'");
