<?php
/**
 * Parameters for ratings config implantation into extensions
 *
 * @package ratings
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

// Options for implantation
$rat_options = array(
	array(
		'name' => 'enable_ratings',
		'type' => COT_CONFIG_TYPE_RADIO,
		'default' => '1'
	)
);

// Modules list to implant into their root config
$rat_extensions_list = array();

// Module list to implant into their structure config
$rat_extensions_struct_list = array('page');
