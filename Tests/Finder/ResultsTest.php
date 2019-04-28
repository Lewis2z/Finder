<?php
use PHPUnit\Framework\TestCase;

class ResultsTest extends TestCase
{
    public function testResultsReorderOnAssignment() {

        $result1 = new \Finder\SearchResult();
        $result1->filename = "result1.txt";
        $result1->score = 1;

        $result2 = new \Finder\SearchResult();
        $result2->filename = "result2.txt";
        $result2->score = 6;

        $result3 = new \Finder\SearchResult();
        $result3->filename = "result3.txt";
        $result3->score = 4;

        $results_list = [
            $result1,
            $result2,
            $result3
        ];

        $results = new \Finder\Results($results_list);
        $results_final_list = $results->get();


        $this->assertEquals($results_final_list[0]->filename, "result2.txt");
        $this->assertEquals($results_final_list[1]->filename, "result3.txt");
        $this->assertEquals($results_final_list[2]->filename, "result1.txt");
    }

    public function testResultsRemoveZeroScoresFilter() {

        $result1 = new \Finder\SearchResult();
        $result1->filename = "result1.txt";
        $result1->score = 1;

        $result2 = new \Finder\SearchResult();
        $result2->filename = "result2.txt";
        $result2->score = 6;

        $result3 = new \Finder\SearchResult();
        $result3->filename = "result3.txt";
        $result3->score = 0;

        $results_list = [
            $result1,
            $result2,
            $result3
        ];

        $results = new \Finder\Results($results_list);
        $results_final_list = $results->removeZeroScores()->get();


        $this->assertEquals($results_final_list[0]->filename, "result2.txt");
        $this->assertEquals($results_final_list[1]->filename, "result1.txt");
        $this->assertTrue(!isset($results_final_list[2]));
    }

    public function testResultsLimitFilter() {

        $result1 = new \Finder\SearchResult();
        $result1->filename = "result1.txt";
        $result1->score = 1;

        $result2 = new \Finder\SearchResult();
        $result2->filename = "result2.txt";
        $result2->score = 6;

        $result3 = new \Finder\SearchResult();
        $result3->filename = "result3.txt";
        $result3->score = 0;

        $results_list = [
            $result1,
            $result2,
            $result3
        ];

        $results = new \Finder\Results($results_list);
        $results_final_list = $results->limit(1)->get();


        $this->assertEquals($results_final_list[0]->filename, "result2.txt");
        $this->assertTrue(!isset($results_final_list[1]));
        $this->assertTrue(!isset($results_final_list[2]));
    }

    public function testResultsPercentagesFilter() {

        $result1 = new \Finder\SearchResult();
        $result1->filename = "result1.txt";
        $result1->score = 6;

        $result2 = new \Finder\SearchResult();
        $result2->filename = "result2.txt";
        $result2->score = 1;

        $result3 = new \Finder\SearchResult();
        $result3->filename = "result3.txt";
        $result3->score = 0;

        $results_list = [
            $result1,
            $result2,
            $result3
        ];

        $results = new \Finder\Results($results_list);
        $results_final_list = $results->get();


        $this->assertEquals($results_final_list[0]->score_pct, 100);
        $this->assertEquals($results_final_list[1]->score_pct, 16);
        $this->assertEquals($results_final_list[2]->score_pct, 0);
    }
}