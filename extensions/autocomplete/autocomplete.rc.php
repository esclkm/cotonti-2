<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

/**
 * Header file for Autocomplete
 *
 * @package autocomplete
 * @version 0.8.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');


if ($cfg['jquery'] && $cfg['turnajax'] && $cfg['autocomplete']['autocomplete'] > 0)
{
	cot_rc_add_file($cfg['extensions_dir'] . '/autocomplete/lib/jquery.autocomplete.min.js');
	if($cfg['autocomplete']['css'])
	{
		cot_rc_add_file($cfg['extensions_dir'] . '/autocomplete/lib/jquery.autocomplete.css');
	}

	cot_rc_add_embed('autocomplete', '
		$(document).ready(function(){
		    $( document ).on( "focus", ".userinput", function() {
		        $(".userinput").autocomplete("index.php?r=autocomplete", {multiple: true, minChars: '.$cfg['autocomplete']['autocomplete'].'});
		    });
		});
	');
}
