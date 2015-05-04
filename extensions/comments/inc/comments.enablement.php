<?php
/**
 * Parameters for comments config implantation into extensions
 *
 * @package comments
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

// Options for implantation
$com_options = array(
	array(
		'name' => 'enable_comments',
		'type' => COT_CONFIG_TYPE_RADIO,
		'default' => '1'
	)
);

// Modules list to implant into their root config
$com_extensions_list = array('polls');

// Module list to implant into their structure config
$com_extensions_struct_list = array('page');
