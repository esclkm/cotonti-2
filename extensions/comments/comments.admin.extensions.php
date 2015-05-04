<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.extensions.install.tags
[END_COT_EXT]
==================== */

/**
 * Implants missing enablement configs when a new extensions is installed
 *
 * @package comments
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require cot_incfile('comments', 'enablement');

if (in_array($code, $com_extensions_list) && !cot_config_implanted($code, 'comments'))
{
	cot_config_implant($code, $com_options, false, 'comments');
}
elseif (in_array($code, $com_extensions_struct_list) && !cot_config_implanted($code, 'comments'))
{
	cot_config_implant($code, $com_options, true, 'comments');
}
