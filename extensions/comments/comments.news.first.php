<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=news.first
[END_COT_EXT]
==================== */

/**
 * Joins into the main news query
 *
 * @package comments
 * @version 0.9.1
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_com;

require_once cot_incfile('comments', 'functions');

$news_join_columns .= ", (SELECT COUNT(*) FROM `$db_com` WHERE com_area = 'page' AND com_code = p.page_id) AS com_count";
