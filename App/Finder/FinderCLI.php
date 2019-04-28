<?php

namespace Finder;

/**
 * FinderCLI extends the Finder class for searching for content in text files
 * This is for use in CLI mode
 *
 * Simple usage:
 * 
 * $finder = new \FinderCLI();
 * $finder->applyStopwords("<path>/stopwords.txt");
 * $finder->indexDirectory("<path_to_text_files_directory>"); // Stopwords are used in the indexing process
 * 
 * $finder->maxResults(10);
 * $finder->startCliUserInput();
 *
 * @author   Lewis Tooze <lewis.e-mail@hotmail.co.uk>
 * @access   public
 * @license  GPL
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class FinderCLI extends \Finder\Finder
{
	private $max_results = 50;

	/**
	 * maxResults
	 * Sets the max_results setting.
	 * When searching using the startCliUserInput, this is the number of results which will be printed to the screen.
	 * @param int $value
	 * @return void
	 */
	public function maxResults(int $value) : void {
		$this->max_results = $value;
	}

	/**
	 * startCliUserInput
	 * Runs the nessary UI for users to have an interactive search in the command line
	 * @return void
	 */
	public function startCliUserInput() : void {

		// Infinate loop
		while (true) {
			// Display the input on the console and get the users response
			$search_query = $this->getUserInput("Search: ");

			// If the user types ':q' or :quit' then exit
			if ($search_query == ":quit") exit();
			if ($search_query == ":q") exit();

			// Get the results from the user's search query
			$results = $this->search($search_query);

			// Filter the results
			$rs = $results
				->limit($this->max_results)
				->removeZeroScores()
				->get();


			// Print the results to the screen
			if (count($rs) > 0) {
				foreach($rs as $result) {
					echo $result->toString().PHP_EOL;
				}
			} else {
				echo "No results found".PHP_EOL;
			}

			// Spacer for the next iteration
			echo PHP_EOL;
		}
		
	}

	/**
	 * getUserInput
	 * Prints a message to the CLI and waits for the user's input
	 * @param string $message
	 * @return void
	 */
	public function getUserInput(string $message) : string {
		echo $message;
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		return trim($line);
	}
}