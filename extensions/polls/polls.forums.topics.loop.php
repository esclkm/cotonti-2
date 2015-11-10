<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.topics.loop
[END_COT_EXT]
==================== */

/**
 * Polls
 *
 * @package polls
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if ($row['poll_id'] > 0)
{
	$row['ft_title'] = $L['Poll'].": ".$row['ft_title'];
}

$t-> assign(array(
	'FORUMS_TOPICS_ROW_TITLE' => htmlspecialchars($row['ft_title'])
));
