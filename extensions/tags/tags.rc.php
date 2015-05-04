<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

/**
 * Head resources
 *
 * @package tags
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

//cot_headrc_load_file($cfg['extensions_dir'] . '/tags/style.css', 'global', 'css');
if ($cfg['jquery'] && $cfg['turnajax'] && $cfg['autocomplete']['autocomplete'] > 0)
{
	cot_rc_add_embed('tags.autocomplete', '$(document).ready(function(){
$(".autotags").autocomplete("'.cot_url('index', 'r=tags').'", {multiple: true, minChars: '.$cfg['autocomplete']['autocomplete'].'});
});');
}
if($cfg['tags']['css'])
{
	cot_rc_add_file($cfg['extensions_dir'] . '/tags/tpl/tags.css');
}
