<?php
use PHPUnit\Framework\TestCase;

class FinderTest extends TestCase
{
    public function testIndexCount() {
        
        $finder = new \Finder\Finder();#
	    $count = $finder->indexDirectory(__DIR__."/../TestData/FinderTest/testIndexCount");
        $this->assertEquals($count, 3);

    }

    public function testSearchResults() {

        // The files abyss.txt and poem-1.txt are meant to be in the dataset.
        // Just to make sure they get indexed but don't appear in the results.
        
        $finder = new \Finder\Finder();
        $finder->applyStopwords(__DIR__."/../TestData/FinderTest/testSearchResults/stopwords.txt");
        $finder->indexDirectory(__DIR__."/../TestData/FinderTest/testSearchResults/Dataset");
        
        $query = "Pacific Northwest Spring night";

        $results = $finder->search($query);
        $rs = $results
            ->limit(5)
            ->removeZeroScores()
            ->get();

        // Only 5 results (as per the limit filter)
        $this->assertEquals(count($rs), 5);

        // Result 1
        $this->assertEquals($rs[0]->score_pct, 100);
        $this->assertEquals($rs[0]->score, 309);
        $this->assertEquals($rs[0]->filename, "friends.txt");

        // Result 2
        $this->assertEquals($rs[1]->score_pct, 22);
        $this->assertEquals($rs[1]->score, 69);
        $this->assertEquals($rs[1]->filename, "hound-b.txt");

        // Result 3
        $this->assertEquals($rs[2]->score_pct, 13);
        $this->assertEquals($rs[2]->score, 41);
        $this->assertEquals($rs[2]->filename, "radar_ra.txt");

        // Result 4
        $this->assertEquals($rs[3]->score_pct, 10);
        $this->assertEquals($rs[3]->score, 33);
        $this->assertEquals($rs[3]->filename, "history5.txt");

        // Result 5
        $this->assertEquals($rs[4]->score_pct, 10);
        $this->assertEquals($rs[4]->score, 31);
        $this->assertEquals($rs[4]->filename, "gulliver.txt");

    }
}