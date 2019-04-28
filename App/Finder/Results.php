<?php

namespace Finder;

/**
 * Results contains the results of a search where filters can be applied. When retrieving the results, a relevancy percent is automatically applied.
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Results
{
	/**
	 * $results
	 * Collection of Results
	 * @var array
	 */
	private $results = array();

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

	/**
	 * __construct
	 * Stores the results and initially sorts them
	 * @param array $results
	 * @return void
	 */
	function __construct(array $results) {
		$this->results = $results;
		
		// Sort by score highest to lowest
		usort($this->results,function($first,$second){
			return $first->score < $second->score;
		});
	}

	/**
	 * limit
	 * Limits the results
	 * @param int $max_results
	 * @return Results
	 */
	public function limit(int $max_results) : Results {
		if ($max_results > 0) {
			$this->results = array_slice($this->results, 0, $max_results);
		}

		return $this;
	}
	
	/**
	 * removeZeroScores
	 * Removes all results with a score of 0
	 * @return Results
	 */
	public function removeZeroScores() : Results {
		$tmp = array();
		foreach ($this->results as $result) {
			if ($result->score > 0) $tmp[] = $result;
		}
		unset($this->results);
		$this->results = $tmp;
		unset($tmp);

		return $this;
	}
	

	/**
	 * get
	 * Applies the percentage to each result and returns the results list array
	 * @return array
	 */
	public function get() : array {

		// Get the score percentage for the results
		$highest_score = 0;
		foreach ($this->results as $result) {
			if ($result->score > $highest_score) $highest_score = $result->score;
		}
		foreach ($this->results as $result) {
			$result->setScorePercent(($result->score / $highest_score) * 100);
		}

		return $this->results;
	}
}