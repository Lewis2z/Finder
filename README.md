﻿﻿﻿
# Finder

Finder is a lightweight tool to quickly find a search term in a set of text files. The results are scored on relevancy.

Indexes are stored in-memory; so the more that needs indexing, the more memory you will need to allocate.

## PHP  Usage
```php
$finder = new \Finder\Finder();

// Stopwords are a list of words that are not relevant to a search (a, and, to, the)
// Excluding these will increase search relevancy and reduce indexing and search times.
$finder->applyStopwords("<path>/stopwords.txt");

// The directory to index (by default this will index with word combinations of up to 5)
$finder->indexDirectory("<path_to_text_files_directory>");

// If word combinations are found, this boosts the result to increase relevancy.
// This compounds; so the more words that are matched together, the more the score will be boosted
$finder->wordCombinationBoostFactor(10);

// Perform the search
$results = $finder->search("Search for this text");

// Filter the results and put them into an array
$rs = $results
	->limit(10) // Limit
	->removeZeroScores() // Removes results without a score (irrelevant results)
	->get(); // Gets an array

// Loop through the array of filtered results
foreach($rs as $result) {

	// Though the toString will put the data into a simple form, you
	// can use ->score, ->score_pct and ->filename for other rendering purposes
	echo  $result->toString(true).PHP_EOL;

}
```

## CLI Demo Usage
```sh
php demo.php <directory to search>
```

## CLI PHP Simple Usage
This will display an input for your search term

```sh
Search: <search_term_here>
```
You can type `:q` or `:quit` to exit


```php
$finder = new \Finder\FinderCLI();

// Stopwords are a list of words that are not relevant to a search (a, and, to, the)
// Excluding these will increase search relevancy and reduce indexing and search times.
$finder->applyStopwords("<path>/stopwords.txt");

// The directory to index
$finder->indexDirectory("<path_to_text_files_directory>");

// Set the maximum number of results to return when searching
$finder->maxResults(10);

// Start the CLI search
$finder->startCliUserInput();
````

## REQUIREMENTS
- PHP 7.2

## AUTHOR
[Lewis Tooze](https://twitter.com/lewis_2z)

## LICENSE
GNU General Public Licence






