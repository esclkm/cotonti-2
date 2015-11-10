<?php
/**
 * @package Feliz
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/* === Hook === */
foreach (cot_getextensions('footer.first') as $ext)
{
	include $ext;
}
/* ===== */

if (!COT_AJAX)
{
	/* === Hook === */
	foreach (cot_getextensions('footer.main') as $ext)
	{
		include $ext;
	}
	/* ===== */

	if ($cfg['enablecustomhf'])
	{
		$mtpl_base = array('footer', $e);
	}
	else
	{
		$mtpl_base = 'footer';
	}
	
	$t = new FTemplate(cot_tplfile($mtpl_base, 'system'));
	$t->assign(array(
		'FOOTER_COPYRIGHT' => $out['copyright'],
		'FOOTER_LOGSTATUS' => $out['logstatus'],
		'FOOTER_PMREMINDER' => $out['pmreminder'],
		'FOOTER_ADMINPANEL' => $out['adminpanel']
	));

	/* === Hook === */
	foreach (cot_getextensions('footer.tags') as $ext)
	{
		include $ext;
	}
	/* ===== */

	// Attach rich text editors if any
	if ($cot_textarea_count > 0)
	{
		if (is_array($cot_hooks['editor']))
		{
			$parser = !empty($sys['parser']) ? $sys['parser'] : $cfg['parser'];
			$editor = $cfg[$parser]['editor'];
			foreach ($cot_hooks['editor'] as $k)
			{
				if ($k['ext_code'] == $editor && cot_auth($k['ext_code'], 'any', 'R'))
				{
					include $cfg['extensions_dir'] . '/' . $k['ext_file'];
					break;
				}
			}
		}
	}

	$t->assign('FOOTER_RC', $out['footer_rc']);

	if ($usr['id'] > 0)
	{
		$t->assign('FOOTER_USER');
	}
	else
	{
		$t->assign('FOOTER_GUEST');
	}

	if ($cfg['debug_mode'])
	{
		$cot_hooks_fired[] = 'footer.last';
		$cot_hooks_fired[] = 'output';
		$out['hooks'] = '<ol>';
		foreach ($cot_hooks_fired as $hook)
		{
			$out['hooks'] .= '<li>'.$hook.'</li>';
		}
		$out['hooks'] .= '</ol>';
		$t->assign('FOOTER_HOOKS', $out['hooks']);
	}

	// Creation time statistics
	$i = explode(' ', microtime());
	$sys['endtime'] = $i[1] + $i[0];
	$sys['creationtime'] = round(($sys['endtime'] - $sys['starttime']), 3);

	$out['creationtime'] = (!$cfg['disablesysinfos']) ? $L['foo_created'].' '.cot_declension($sys['creationtime'], $Ls['Seconds'], $onlyword = false, $canfrac = true) : '';
	$out['sqlstatistics'] = ($cfg['showsqlstats']) ? $L['foo_sqltotal'].': '.cot_declension(round($db->timeCount, 3), $Ls['Seconds'], $onlyword = false, $canfrac = true).' - '.$L['foo_sqlqueries'].': '.$db->count. ' - '.$L['foo_sqlaverage'].': '.cot_declension(round(($db->timeCount / $db->count), 5), $Ls['Seconds'], $onlyword = false, $canfrac = true) : '';
	$out['bottomline'] = $cfg['bottomline'];
	$out['bottomline'] .= ($cfg['keepcrbottom']) ? $out['copyright'] : '';

	// Development mode SQL query timings
	if ($cfg['devmode'] && cot_auth('admin', 'a', 'A'))
	{
		$out['devmode'] = "<h4>Dev-mode :</h4><table><tr><td><em>SQL query</em></td><td><em>Duration</em></td><td><em>Timeline</em></td><td><em>Execution stack<br />(file[line]: function)</em></td><td><em>Query</em></td></tr>";
		$out['devmode'] .= "<tr><td colspan=\"2\">BEGIN</td>";
		$out['devmode'] .= "<td style=\"text-align:right;\">0.000 ms</td><td>&nbsp;</td></tr>";
		if(is_array($sys['devmode']['queries']))
		{
			foreach ($sys['devmode']['queries'] as $k => $i)
			{
				$out['devmode'] .= "<tr><td>#".$i[0]." &nbsp;</td>";
				$out['devmode'] .= "<td style=\"text-align:right;\">".sprintf("%.3f", round($i[1] * 1000, 3))." ms</td>";
				$out['devmode'] .= "<td style=\"text-align:right;\">".sprintf("%.3f", round($sys['devmode']['timeline'][$k] * 1000, 3))." ms</td>";
				$out['devmode'] .= "<td style=\"text-align:left;\">".nl2br(htmlspecialchars($i[3]))."</td>";
				$out['devmode'] .= "<td style=\"text-align:left;\">".htmlspecialchars($i[2])."</td></tr>";
			}
		}
		$out['devmode'] .= "<tr><td colspan=\"2\">END</td>";
		$out['devmode'] .= "<td style=\"text-align:right;\">".sprintf("%.3f", $sys['creationtime'])." ms</td><td>&nbsp;</td></tr>";
		$out['devmode'] .= "</table><br />Total:".round($db->timeCount, 4)."s - Queries:".$db->count. " - Average:".round(($db->timeCount / $db->count), 5)."s/q";
	}

	$t->assign(array(
		'FOOTER_BOTTOMLINE' => $out['bottomline'],
		'FOOTER_CREATIONTIME' => $out['creationtime'],
		'FOOTER_SQLSTATISTICS' => $out['sqlstatistics'],
		'FOOTER_DEVMODE' => $out['devmode']
	));

	$t->out();
}

/* === Hook === */
foreach (cot_getextensions('footer.last') as $ext)
{
	include $ext;
}
/* ===== */
