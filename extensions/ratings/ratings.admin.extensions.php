<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.extensions.install.tags
[END_COT_EXT]
==================== */

/**
 * Implants missing enablement configs when a new extension is installed
 *
 * @package ratings
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require cot_incfile('ratings', 'enablement');

if (in_array($code, $rat_extensions_list) && !cot_config_implanted($code, 'ratings'))
{
	cot_config_implant($code, $rat_options, false, 'ratings');
}
elseif (in_array($code, $rat_extensions_struct_list) && !cot_config_implanted($code, 'ratings'))
{
	cot_config_implant($code, $rat_options, true, 'ratings');
}
