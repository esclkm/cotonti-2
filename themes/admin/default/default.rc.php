<?php
/**
 * JavaScript and CSS loader for Nemesis theme
 *
 * @package Cotonti
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

global $cfg, $usr;

cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/css/bootstrap.css');

cot_rc_add_file($cfg['themes_dir'].'/'.$usr['theme'].'/js/bootstrap.js');



$R['input_checkbox'] = '<input type="hidden" name="{$name}" value="{$value_off}" /><label><input type="checkbox" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_check'] = '<label><input type="checkbox" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_default'] = '<input type="{$type}" name="{$name}" value="{$value}"{$attrs} />{$error}';
$R['input_option'] = '<option value="{$value}"{$selected}>{$title}</option>';
$R['input_radio'] = '<label><input type="radio" name="{$name}" value="{$value}"{$checked}{$attrs} /> {$title}</label>';
$R['input_radio_separator'] = ' ';
$R['input_select'] = '<select name="{$name}" class="form-control" {$attrs}>{$options}</select>{$error}';
$R['input_submit'] = '<button type="submit" name="{$name}" {$attrs}>{$value}</button>';
$R['input_text'] = '<input type="text" name="{$name}" value="{$value}" class="form-control" {$attrs} />{$error}';
$R['input_textarea'] = '<textarea name="{$name}" rows="{$rows}" cols="{$cols}" class="form-control"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_editor'] =  '<textarea class="editor" name="{$name}" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_medieditor'] =  '<textarea class="medieditor" name="{$name}" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_textarea_minieditor'] =  '<textarea class="minieditor" name="{$name}" rows="{$rows}" cols="{$cols}"{$attrs}>{$value}</textarea>{$error}';
$R['input_filebox'] = '<a href="{$filepath}">{$value}</a><br /><input type="file" name="{$name}" {$attrs} /><br /><label><input type="checkbox" name="{$delname}" value="1" />'.$L['Delete'].'</label>{$error}';
$R['input_filebox_empty'] = '<input type="file" name="{$name}" class="form-control" {$attrs} />{$error}';

$R['input_date'] =  '<span class="dateinput">{$day} {$month} {$year} {$hour}: {$minute}</span>';
$R['input_date_short'] =  '<span class="dateinput">{$day} {$month} {$year}</span>';

$R['link_pagenav_current'] = '<li class="active"><a href="{$url}"{$event}{$rel}>{$num}</a><li>';
$R['link_pagenav_first'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_first'].'</a><li>';

$R['link_pagenav_gap'] = '<li class="disabled"><span>...</span></li>';
$R['link_pagenav_last'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_last'].'</a></li>';
$R['link_pagenav_main'] = '<li><a href="{$url}"{$event}{$rel}>{$num}</a></li>';
$R['link_pagenav_next'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_next'].'</a></li>';
$R['link_pagenav_prev'] = '<li><a href="{$url}"{$event}{$rel}>'.$L['pagenav_prev'].'</a></li>';

$R['breadcrumbs_container'] = '<ol class="breadcrumb">{$crumbs}</ol>';
$R['breadcrumbs_link'] = '<li><a href="{$url}">{$title}</a></li>';
$R['breadcrumbs_plain'] = '<li>{$title}</li>';
$R['breadcrumbs_separator'] = '';
$R['breadcrumbs_first'] = '<li><a href="'.$cfg['mainurl'].'"><span class="glyphicon glyphicon-home"></span> Главная</a></li>';

function page_delete_url($id)
{
	global $sys;
	$delete_url = cot_url('page', "m=edit&a=update&delete=1&id={$id}&x={$sys['xk']}");
	return cot_confirm_url($delete_url, 'page', 'page_confirm_delete');
}

$L['breadcrumbmaintitle'] = "Главная";
$cfg['homebreadcrumb'] = true;