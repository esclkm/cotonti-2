<?php

/**
 * Parses PHPDoc file header into an array
 *
 * @param string $filename Path to a PHP file
 * @return array Associative array containing PHPDoc contents. The array is
 *  empty if no PHPDoc was found
 */
function cot_file_phpdoc($filename)
{
	$res = array();
	$data = file_get_contents($filename);
	if (preg_match('#^/\*\*(.*?)^\s\*/#ms', $data, $mt))
	{
		$phpdoc = preg_split('#\r?\n\s\*\s@#', $mt[1]);
		$cnt = count($phpdoc);
		if ($cnt > 0)
		{
			$res['description'] = trim(preg_replace('#\r?\n\s\*\s?#', '',
				$phpdoc[0]));
			for ($i = 1; $i < $cnt; $i++)
			{
				$delim = mb_strpos($phpdoc[$i], ' ');
				$key = mb_substr($phpdoc[$i], 0, $delim);
				$contents = trim(preg_replace('#\r?\n\s\*\s?#', '',
					mb_substr($phpdoc[$i], $delim + 1)));
				$res[$key] = $contents;
			}
		}
	}
	return $res;
}
