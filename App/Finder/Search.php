<?php

namespace Finder;

/**
 * Search builds a list of Results from the search query and the stored indexes
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Search
{

	/**
	 * $indexes
	 * Collection of IndexItems
	 * @var array
	 */
	private $indexes = array();

	/**
	 * $word_combination_boost_factor
	 * This stores the boost factor used when multiple words are matched
	 * @var integer
	 */
	private $word_combination_boost_factor = 1;

	/**
	 * $results
	 * Collection of Results
	 * @var Results
	 */
	private $results;

	/**
	 * __construct
	 *
	 * @param array $indexes
	 * @param int $word_combination_boost_factor
	 * @return void
	 */
	function __construct(array $indexes, int $word_combination_boost_factor = 1) {
		$this->indexes = $indexes;
		$this->word_combination_boost_factor = $word_combination_boost_factor;
	}

	/**
	 * go
	 * Runs through the indexes to form a list of results
	 * @param string $query
	 * @return void
	 */
	public function go(string $query) : void {

		$results_list = array();
		foreach($this->indexes as $index) {
			$result = new SearchResult();
			$result->evaluate($query, $index, $this->word_combination_boost_factor);

			$results_list[] = $result;
		}
		$this->results = new Results($results_list);
	}

	/**
	 * getResults
	 * Gets the results
	 * @return Results
	 */
	public function getResults() : Results {
		return $this->results;
	}
}