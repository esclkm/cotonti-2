<?php
/**
 * Installs ratings into extensions
 *
 * @package ratings
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require cot_incfile('ratings', 'enablement');

// Add options into extension configs
foreach ($rat_extensions_list as $mod_name)
{
	if (cot_extension_installed($mod_name) && !cot_config_implanted($mod_name, 'ratings'))
	{
		cot_config_implant($mod_name, $rat_options, false, 'ratings');
	}
}

// Add options into extension structure configs
foreach ($rat_extensions_struct_list as $mod_name)
{
	if (cot_extension_installed($mod_name) && !cot_config_implanted($mod_name, 'ratings'))
	{
		cot_config_implant($mod_name, $rat_options, true, 'ratings');
	}
}
