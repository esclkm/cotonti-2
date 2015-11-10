<?php
/**
 * Installs comments into modules
 *
 * @package comments
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require cot_incfile('comments', 'enablement');

// Add options into extensions configs
foreach ($com_extensions_list as $mod_name)
{
	if (cot_extension_installed($mod_name) && !cot_config_implanted($mod_name, 'comments'))
	{
		cot_config_implant($mod_name, $com_options, false, 'comments');
	}
}

// Add options into extensions structure configs
foreach ($com_extensions_struct_list as $mod_name)
{
	if (cot_extension_installed($mod_name) && !cot_config_implanted($mod_name, 'comments'))
	{
		cot_config_implant($mod_name, $com_options, true, 'comments');
	}
}
