<?php
/**
 * Creates HTML Purifier Serializer cache folder
 *
 * @package markitup
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (!file_exists($cfg['cache_dir'] . '/htmlpurifier'))
{
	mkdir($cfg['cache_dir'] . '/htmlpurifier');
}
