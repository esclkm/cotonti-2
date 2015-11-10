<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.emptytopicdel, forums.functions.prunetopics
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

require_once cot_incfile('polls', 'functions');

cot_poll_delete($q, 'forum');
