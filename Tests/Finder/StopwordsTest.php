<?php
use PHPUnit\Framework\TestCase;

class StopwordsTest extends TestCase
{
    public function testStopwordsPopulate() {
        
        $stopwords = new \Finder\Stopwords();

        $stopwords->populate(file_get_contents(__DIR__."/../TestData/StopwordsTest/testStopwordsPopulate.txt"));

        $expected_array = ["a","and","are","is","that","the","this","to"];

        $this->assertEquals($stopwords->stopwords, $expected_array);
    }

    public function testRemoveFromStringRemovesPopulatedStopwords() {
        
        $stopwords = new \Finder\Stopwords();

        $stopwords->populate(file_get_contents(__DIR__."/../TestData/StopwordsTest/testRemoveFromStringRemovesPopulatedStopwords.txt"));

        $test = $stopwords->removeFromString("this is a string to test that the stopwords are removed from this string");

        $expected = "string test stopwords removed from string";

        $this->assertEquals($test, $expected);
    }
}