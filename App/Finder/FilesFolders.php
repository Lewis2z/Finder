<?php

namespace Finder;

/**
 * FilesFolders contains methods for dealing with files and folders
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class FilesFolders
{
	/**
	 * listDirectory
	 * Gets files in a directory
	 * @param string $dir
	 * @return array
	 */
	public static function listDirectory(string $dir) : array {
		$list = array();

		if ($handle = opendir($dir)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && !is_dir($dir."/".$entry)) {
					$list[] = $entry;
				}
			}
			closedir($handle);
		}

		return $list;
	}
}