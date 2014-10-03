<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.extensions.install.tags
[END_COT_EXT]
==================== */

/**
 * Adds i18n support to tags when installing the tags extension after i18n
 *
 * @package i18n
 * @version 0.9.2
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2011-2014
 * @license BSD License
 */

defined('COT_CODE') or die('Wrong URL');

if ($code == 'tags' && $result && !cot_error_found())
{
	include $cfg['extensions_dir'] . '/i18n/setup/i18n.install.php';
}
