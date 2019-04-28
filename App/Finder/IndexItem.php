<?php

namespace Finder;

use \Finder\Exceptions\FileNotFoundException as FileNotFoundException;

/**
 * IndexItem builds an index from a file and stores the content as an in-memory representation.
 *
 * @package  Finder
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class IndexItem
{

	/**
	 * $file_path
	 *
	 * @var string
	 */
	public $file_path = "";

	/**
	 * $content_index
	 * Collection of word combinations
	 * @var array
	 */
	public $content_index = array();

	/**
	 * __construct
	 *
	 * @param string $file_path
	 * @param Stopwords Stopwords
	 * @param int $word_combination_length
	 * @return void
	 */
	function __construct(string $file_path, Stopwords $stopwords = null, int $word_combination_length = 1) {
		$this->file_path = $file_path;

		if (!file_exists($file_path)) {
			throw new FileNotFoundException(\Finder\Errors::file_not_found);
		}

		// Start the indexing process
		$this->processIndex($stopwords, $word_combination_length);
	}

	/**
	 * processIndex
	 *
	 * @param Stopwords Stopwords
	 * @param int $word_combination_length
	 * @return void
	 */
	public function processIndex(Stopwords $stopwords = null, int $word_combination_length = 1) : void {
		$file_contents = file_get_contents($this->file_path);
		
		$file_contents = Strings::cleanString($file_contents);

		// If stopwords are applied, remove them
		if (!is_null($stopwords)) {
			$file_contents = $stopwords->removeFromString($file_contents);
		}

		// Get and store the combinations of words
		$combinations = Strings::getWordCombinations($file_contents, $word_combination_length);
		$this->content_index = $combinations;

	}

}