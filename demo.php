<?php

require("./vendor/autoload.php");

$path = $argv[1] ?? "";

// Create a new FinderCLI
$finder = new \Finder\FinderCLI();

// Load the stopwords
try {
	$finder->applyStopwords("./Config/stopwords.txt");
} catch (\Finder\Exceptions\FileNotFoundException $e) {
	echo PHP_EOL."Error: ".$e->message.PHP_EOL;
	exit();
} catch (Exception $e) {
	print_r($e);
}

// Index the specified directory
try {

	echo "Indexing directory...";
	$count = $finder->indexDirectory($path);
	if ($count > 0) {
		echo " Success (".$count." files indexed)".PHP_EOL.PHP_EOL;
	} else {
		echo PHP_EOL."There are no files in this directory to index. Quitting.";
		exit();
	}
	
} catch (\Finder\Exceptions\DirectoryNotFoundException $e) {
	echo PHP_EOL."Error: ".$e->message.PHP_EOL;
	exit();
} catch (Exception $e) {
	print_r($e);
}

// Set the maximum number of results to return when searching
$finder->maxResults(10);

try {
	// Start the CLI search
	$finder->startCliUserInput();

} catch (Exception $e) {
	print_r($e);
}

echo PHP_EOL.PHP_EOL;