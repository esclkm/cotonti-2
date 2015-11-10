<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=trashcan.api
[END_COT_EXT]
==================== */

/**
 * Trash can functions for comments
 *
 * @package comments
 * @version 0.7.2
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('comments', 'functions');

// Register restoration table
$trash_types['comment'] = $db_com;
