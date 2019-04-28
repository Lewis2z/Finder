<?php

namespace Finder;

/**
 * Stopwords contains a list of specified stopwords and has a method to remove them from any string.
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Stopwords
{
	/**
	 * $stopwords
	 *
	 * @var array
	 */
	public $stopwords = array();

	/**
	 * populate
	 * Store the stopwords on each new line
	 * @param string $data
	 * @return void
	 */
	public function populate(string $data) : void {
		// Cleanup
		$data = Strings::cleanString($data);

		$this->stopwords = explode(" ", $data);
	}

	/**
	 * removeFromString
	 * Removes all stored stopwords from string
	 * @param string $string
	 * @return string
	 */
	public function removeFromString(string $string) : string {
		
		foreach($this->stopwords as $sw) {
			$string = preg_replace('/\b'.$sw.'\b/i', ' ', $string);
		}

		// Remove multiple sequential spaces
		$string = preg_replace('/[\s]{2,999}/', ' ', $string);

		return trim($string);
	}
}