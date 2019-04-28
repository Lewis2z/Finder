<?php

namespace Finder;

/**
 * Strings contains a range of useful methods for dealing with strings.
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Strings
{
	/**
	 * getWordCombinations
	 * This gets combinations of words and their usage counts
	 * i.e.
	 * array(
	 * 		[1] => [
	 * 			"one" => 1,
	 * 			"two" => 5
	 * 		],
	 * 		[2] => [
	 * 			"two words" => 3,
	 * 			"more words => 2
	 * 		]
	 * 		...
	 * )
	 * 
	 * @param string $string
	 * @param int $word_combination_length
	 * @return array
	 */
	public static function getWordCombinations(string $string, int $word_combination_length) : array {
		$combinations = array();

		$words = explode(" ", $string);

		// If the number of words is less than the requested combination length then the words is the limit
		if (count($words) < $word_combination_length) $word_combination_length = count($words);

		// Get each word combination
		for ($combination_length=1; $combination_length <= $word_combination_length; $combination_length++) { 
			foreach ($words as $word_pos => $word) {
				$word_combo = "";
				for ($pos_increment=1; $pos_increment <= $combination_length; $pos_increment++) {
					$new_word_pos = $word_pos + ($pos_increment-1);

					// Probably the end of the string. Break 2 as there is no point in calculating combinations any further.
					if (!isset($words[$new_word_pos])) break 2;

					// Add to word combo
					$word_combo .= ($words[$new_word_pos]??"")." ";
				}
				$word_combo = trim($word_combo);

				// Store for it
				if (isset($combinations[$combination_length][$word_combo])) {
					$combinations[$combination_length][$word_combo]++;
				} else {
					$combinations[$combination_length][$word_combo] = 1;
				}
	
			}

			// Sort by most frequent at the top. This also speeds up interrogation because the more likely terms are at the top.
			arsort($combinations[$combination_length]);
		}

		return $combinations;
	}

	/**
	 * padEnd
	 * padds a string with a character to meet a set length
	 * @param string $string
	 * @param int $length
	 * @param string $with
	 * @return void
	 */
	public static function padEnd(string $string, int $length = 0, string $with = "") : string {
		$s = $string;
		$p = $length - strlen($string);
		if ($p > 0) $s .= str_repeat($with, $p);
		return $s;
	}

	/**
	 * cleanString
	 * This removes new lines, tabs, quotes, most symbols and formats to reduce sequential spaces
	 * @param string $string
	 * @return void
	 */
	public static function cleanString(string $string) : string {

		// Remove new lines and tabs
		$string = str_replace(array("\r", "\n", "\t"), ' ', $string);

		// Remove quotes
		$string = str_replace(array("'", "\""), '', $string);

		// Remove symbols except hyphens and currency
		$string = preg_replace('/[^\£\$ \w-]/', ' ', $string);

		// Remove orphaned hyphens
		$string = str_replace(' - ', ' ', $string);

		// Remove multiple sequential spaces
		$string = preg_replace('/[\s]{2,999}/', ' ', $string);

		// Move everything to lower case
		$string = strtolower($string);

		return trim($string);
	}
}