<?php
use PHPUnit\Framework\TestCase;

class SearchResultTest extends TestCase
{
    public function testSearchResultProperlyEquatesScore_3WordCombo() {
        
        $stopwords = new \Finder\Stopwords();

        $stopwords->populate(file_get_contents(__DIR__."/../TestData/SearchResultTest/testSearchResultProperlyEquatesScore_3WordCombo_stopwords.txt"));
        
        $index_file_path = __DIR__."/../TestData/SearchResultTest/testSearchResultProperlyEquatesScore_3WordCombo_text.txt";
        $index_item = new \Finder\IndexItem($index_file_path, $stopwords, 3);

        $search_result = new \Finder\SearchResult();
        $query = "extraterrestrials traveling on reduced fuel through self-miniaturization"; // This is an extract from the test file
        $query = $stopwords->removeFromString($query);

        // Boost Factor 1 test
        $search_result->evaluate($query, $index_item, 1);
        $this->assertEquals($search_result->score, 31);

        // Boost Factor 5 test
        $search_result->evaluate($query, $index_item, 5); // Having a higher boost factor can increase the score and relevancy
        $this->assertEquals($search_result->score, 166);

    }

    public function testSearchResultProperlyEquatesScore_5WordCombo() {
        
        $stopwords = new \Finder\Stopwords();

        $stopwords->populate(file_get_contents(__DIR__."/../TestData/SearchResultTest/testSearchResultProperlyEquatesScore_5WordCombo_stopwords.txt"));
        
        $index_file_path = __DIR__."/../TestData/SearchResultTest/testSearchResultProperlyEquatesScore_5WordCombo_text.txt";
        $index_item = new \Finder\IndexItem($index_file_path, $stopwords, 5); // See how increasing the indexed combinations can increase the score

        $search_result = new \Finder\SearchResult();
        $query = "extraterrestrials traveling on reduced fuel through self-miniaturization"; // This is an extract from the test file
        $query = $stopwords->removeFromString($query);

        // Boost Factor 1 test
        $search_result->evaluate($query, $index_item, 1);
        $this->assertEquals($search_result->score, 75);

        // Boost Factor 5 test
        $search_result->evaluate($query, $index_item, 5); // Having a higher boost factor can increase the score and relevancy
        $this->assertEquals($search_result->score, 430);

    }

    public function testSearchResultToString() {

        $search_result = new \Finder\SearchResult();
        $search_result->filename = "file1.txt";
        $search_result->score = 123;
        $search_result->score_pct = 4;
        $search_result->filename = "file1.txt";

        $test = $search_result->toString();

        $expected = " 4%   | file1.txt";

        $this->assertEquals($test, $expected);

    }

    public function testSearchResultToStringDebugMode() {

        $search_result = new \Finder\SearchResult();
        $search_result->filename = "file1.txt";
        $search_result->score = 123;
        $search_result->score_pct = 4;
        $search_result->filename = "file1.txt";

        $test = $search_result->toString(true);

        $expected = " 4%   | 123    | file1.txt";

        $this->assertEquals($test, $expected);

    }
}