<?php
/**
 * PFS extensions
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

$cot_hooks = array();

$cot_hooks[] = array ('rar', 'Archive', 'rar');
$cot_hooks[] = array ('zip', 'Archive', 'zip');
$cot_hooks[] = array ('avi', 'Video', 'mov');
$cot_hooks[] = array ('qt', 'Video', 'mov');
$cot_hooks[] = array ('mov', 'Video', 'mov');
$cot_hooks[] = array ('mpeg', 'Video', 'mov');
$cot_hooks[] = array ('mpg', 'Video', 'mov');
$cot_hooks[] = array ('ogg', 'Video', 'mov');
$cot_hooks[] = array ('bmp', 'Picture', 'bmp');
$cot_hooks[] = array ('gif', 'Picture', 'gif');
$cot_hooks[] = array ('jpeg', 'Picture', 'jpg');
$cot_hooks[] = array ('jpg', 'Picture', 'jpg');
$cot_hooks[] = array ('png', 'Picture', 'png');
$cot_hooks[] = array ('mp3', 'Music', 'mp3');
$cot_hooks[] = array ('wav', 'Music', 'wav');
$cot_hooks[] = array ('txt', 'Text', 'txt');
$cot_hooks[] = array ('pdf', 'Adobe document', 'pdf');
