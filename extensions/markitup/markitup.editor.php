<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=editor
[END_COT_EXT]
==================== */

/**
 * MarkItUp! connector for Feliz
 *
 * @package markitup
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['jquery'])
{
	// Language selection
	global $lang;
	$mkup_lang = $cfg['extensions_dir']."/markitup/lang/$lang.lang.js";
	if (!file_exists($mkup_lang))
	{
		$mkup_lang = $cfg['extensions_dir'].'/markitup/lang/en.lang.js';
	}
	$smile_lang = "./images/smilies/lang/$lang.lang.js";
	if (!file_exists($smile_lang))
	{
		$smile_lang = './images/smilies/lang/en.lang.js';
	}

	// BBcode or HTML preset
	$mkup_set = $sys['parser'] == 'bbcode'? 'bbcode' : 'html';

	// Load resources
	$mkup_skin_path = $cfg['extensions_dir'] . '/markitup/skins/' . $cfg['markitup']['skin'] . '/style.css';
	$mkup_skin = cot_rc('code_rc_css_file', array('url' => $mkup_skin_path));
	$mkup_style_path = $cfg['extensions_dir'] . '/markitup/style.css';
	$mkup_style = cot_rc('code_rc_css_file', array('url' => $mkup_style_path));
	cot_rc_link_footer($smile_lang);
	cot_rc_link_footer('images/smilies/set.js');
	cot_rc_link_footer($cfg['extensions_dir'] . '/markitup/js/jquery.markitup.min.js');
	cot_rc_link_footer($mkup_lang);
	cot_rc_link_footer($cfg['extensions_dir'] . "/markitup/js/{$mkup_set}.set.js");

	if ($cfg['markitup']['chili'])
	{
		cot_rc_link_footer($cfg['extensions_dir'].'/markitup/js/chili.js');
	}

	// User-specific setup
	$autorefresh = ($cfg['markitup']['autorefresh']) ? 'true' : 'false';
	cot_rc_embed_footer('$(document).ready(function() {
		if (document.createStyleSheet) { document.createStyleSheet("'.$mkup_skin_path.'"); } else { $("head").append(\''.$mkup_skin.'\'); }
		if (document.createStyleSheet) { document.createStyleSheet("'.$mkup_style_path.'"); } else { $("head").append(\''.$mkup_style.'\'); }
		mySettings.previewAutorefresh = '.$autorefresh.';
		mySettings.previewParserPath = "index.php?r=markitup&x=" + $("input[name=\'x\'][type=\'hidden\']").eq(0).val();
		mediSettings.previewAutorefresh = '.$autorefresh.';
		mediSettings.previewParserPath = mySettings.previewParserPath;
		miniSettings.previewAutorefresh = '.$autorefresh.';
		miniSettings.previewParserPath = mySettings.previewParserPath;
		$("textarea.editor").markItUp(mySettings);
		$("textarea.medieditor").markItUp(mediSettings);
		$("textarea.minieditor").markItUp(miniSettings);
	});');
}
