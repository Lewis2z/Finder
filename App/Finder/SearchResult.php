<?php

namespace Finder;

/**
 * SearchResult performs the task of scoring the query againsed the specified IndexItem. It stores the score and the result can be converted to a string.
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SearchResult
{
	
	/**
	 * $score
	 *
	 * @var integer
	 */
	public $score = 0;

	/**
	 * $score_pct
	 *
	 * @var integer
	 */
	public $score_pct = 0;

	/**
	 * $filename
	 *
	 * @var string
	 */
	public $filename = "";

	function __construct() {
	}

	/**
	 * evaluate
	 * This calculates the query's score againsed the index item
	 * @param string $query
	 * @param IndexItem $index_item
	 * @param int $word_combination_boost_factor
	 * @return void
	 */
	public function evaluate(string $query, IndexItem $index_item, int $word_combination_boost_factor = 1) : void {

		// Store the filename for reference
		$this->filename = basename($index_item->file_path);

		// calculate the score
		
		$query_split = explode(" ", $query);

		$combinations = Strings::getWordCombinations(strtolower($query), count($query_split));

		foreach($combinations as $multiplier => $set) {

			if (isset($index_item->content_index[$multiplier])) {

				$cbf = max((($multiplier-1) * $word_combination_boost_factor), 1);

				foreach($set as $word => $count) {
					$score = $index_item->content_index[$multiplier][$word] ?? 0;
					$score = $score * ($multiplier * $cbf);
					if ($score > 0) $this->score += $score;
				}
			}
		}
	}

	/**
	 * setScorePercent
	 *
	 * @param int $pct
	 * @return void
	 */
	public function setScorePercent(int $pct) : void {
		$this->score_pct = $pct;
	}

	/**
	 * toString
	 * Turns the result information into a string for printing in CLI
	 * @param bool $show_debug_info
	 * @return string
	 */
	public function toString(bool $show_debug_info = false) : string {
		$out = " ";

		// Percent
		$out .= Strings::padEnd($this->score_pct."%", 4, ' ') . " | ";

		if ($show_debug_info) {
			// Score
			$out .= Strings::padEnd($this->score, 6, ' ') . " | ";
		}

		// Filename
		$out .= $this->filename;

		return $out;
	}
}