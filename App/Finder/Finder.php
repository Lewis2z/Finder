<?php

namespace Finder;

use Finder\Exceptions\DirectoryNotFoundException as DirectoryNotFoundException;
use Finder\Exceptions\FileNotFoundException as FileNotFoundException;

/**
 * Finder is a class for searching for content in text files
 *
 * Simple usage:
 * 
 * $finder = new \Finder\Finder();
 * $finder->applyStopwords("<path>/stopwords.txt");
 * $finder->indexDirectory("<path_to_text_files_directory>"); // Stopwords are used in the indexing process
 * 
 * $results = $finder->search("Search for this text");
 * $rs = $results
 *		->limit(10)
 *		->removeZeroScores()
 *		->get();
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license	 GPL
 * @license	 http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Finder
{

	/**
	 * $stopwords
	 * Stopwords object
	 * @var Stopwords
	 */
	private $stopwords;

	/**
	 * $indexes
	 * Collection of IndexItems
	 * @var array
	 */
	private $indexes = array();

	/**
	 * $settings
	 * Collection of settings with some default values
	 * @var array
	 */
	private $settings = array(
		"index_word_combinations" => 5,
		"word_combination_boost_factor" => 10
	);

	function __construct() {
	}

	/**
	 * applyStopwords
	 * Provide a list of stopwords to filter out of the query and indexing process
	 * @param string $path
	 * @return void
	 */
	public function applyStopwords(string $path) : void {
		
		if (!file_exists($path)) {
			throw new FileNotFoundException(\Finder\Errors::file_not_found);
		}

		// Make a new Stopwords object and populate it with the file's data
		$this->stopwords = new Stopwords();
		$this->stopwords->populate(file_get_contents($path));
	}

	/**
	 * indexWordCombinations
	 * Sets the index_word_combinations setting
	 * The value must always be a minimum of 1 (for 1 word)
	 * @param int $value
	 * @return void
	 */
	public function indexWordCombinations(int $value) : void {
		$this->settings["index_word_combinations"] = max($value, 1);
	}

	/**
	 * wordCombinationBoostFactor
	 * Sets the word_combination_boost_factor setting
	 * The value must always be a minimum of 1 (for no effect)
	 * @param int $value
	 * @return void
	 */
	public function wordCombinationBoostFactor(int $value) : void {
		$this->settings["word_combination_boost_factor"] = max($value, 1);
	}

	/**
	 * indexDirectory
	 * Provide a directory and it will get indexed
	 * @param string $dir_path
	 * @return int
	 */
	public function indexDirectory(string $dir_path) : int {

		// Clean up dir path
		$dir_path = rtrim($dir_path, "/");

		if (!is_dir($dir_path)) {
			throw new DirectoryNotFoundException(\Finder\Errors::directory_not_found);
		}

		// Get a list of the files
		$files_list = FilesFolders::listDirectory($dir_path);

		// Index each file
		foreach ($files_list as $file) $indexes[] = new IndexItem($dir_path."/".$file, $this->stopwords, $this->settings['index_word_combinations']);
		
		// Store the indexes
		$this->indexes = $indexes;

		// return a count for information purposes
		return count($indexes);
	}

	/**
	 * search
	 * Makes a new search and returns the results
	 * @param string $query
	 * @return Results
	 */
	public function search(string $query) : Results {

		// Remove anything unusual
		$query = Strings::cleanString($query);

		// Remove the stopwords from the query. As they are not indexed anyway, theres no reason to search againsed them.
		if (!is_null($this->stopwords)) $query = $this->stopwords->removeFromString($query);

		// Perform the search
		$search = new Search($this->indexes, (int)$this->settings["word_combination_boost_factor"]);
		$search->go($query);
		return $search->getResults();
	}
}