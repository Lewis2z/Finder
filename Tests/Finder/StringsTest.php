<?php
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function testPadEndReturnsCorrectPadding() {
        
        $test = \Finder\Strings::padEnd("test", 5, " ");

        $expected = "test ";

        $this->assertEquals($test, $expected);
    }

    public function testCleanStringReturnsACleanedString() {
        
        $test = '
            No symbols should come through except select ones.
            It keeps things like hyphens in certain test-cases - unless they are orphaned - and dollars and pounds because the price of something at £1 or $1 may be important.
            Additionally, there should be no new lines or tabs and everything should be LOWERCASE.
            Extra  spacing   will    also     be      removed.
            Lewis says "quotes should be removed for the relevancy\'s sake"
        ';

        $expected = "no symbols should come through except select ones it keeps things like hyphens in certain test-cases unless they are orphaned and dollars and pounds because the price of something at £1 or $1 may be important additionally there should be no new lines or tabs and everything should be lowercase extra spacing will also be removed lewis says quotes should be removed for the relevancys sake";

        $this->assertEquals(\Finder\Strings::cleanString($test), $expected);
    }

    public function testWordCombinationsOutputTheCorrectData() {
        
        $test = "this is to calculate how many words are re-used in a string of words and it also has to calculate combinations";
        $test_json = json_encode(\Finder\Strings::getWordCombinations($test, 3));

        $expected_json = '
            {
                "1": {
                    "to": 2,
                    "calculate": 2,
                    "words": 2,
                    "this": 1,
                    "string": 1,
                    "has": 1,
                    "also": 1,
                    "it": 1,
                    "and": 1,
                    "of": 1,
                    "in": 1,
                    "a": 1,
                    "is": 1,
                    "re-used": 1,
                    "are": 1,
                    "many": 1,
                    "how": 1,
                    "combinations": 1
                },
                "2": {
                    "to calculate": 2,
                    "this is": 1,
                    "string of": 1,
                    "has to": 1,
                    "also has": 1,
                    "it also": 1,
                    "and it": 1,
                    "words and": 1,
                    "of words": 1,
                    "in a": 1,
                    "a string": 1,
                    "is to": 1,
                    "re-used in": 1,
                    "are re-used": 1,
                    "words are": 1,
                    "many words": 1,
                    "how many": 1,
                    "calculate how": 1,
                    "calculate combinations": 1
                },
                "3": {
                    "this is to": 1,
                    "a string of": 1,
                    "has to calculate": 1,
                    "also has to": 1,
                    "it also has": 1,
                    "and it also": 1,
                    "words and it": 1,
                    "of words and": 1,
                    "string of words": 1,
                    "in a string": 1,
                    "is to calculate": 1,
                    "re-used in a": 1,
                    "are re-used in": 1,
                    "words are re-used": 1,
                    "many words are": 1,
                    "how many words": 1,
                    "calculate how many": 1,
                    "to calculate how": 1,
                    "to calculate combinations": 1
                }
            }
        ';

        $this->assertJsonStringEqualsJsonString($test_json, $expected_json);
    }
}