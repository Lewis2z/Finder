<?php
use PHPUnit\Framework\TestCase;

class IndexItemTest extends TestCase
{
    public function testIndexItemIndexes() {
        
        $stopwords = new \Finder\Stopwords();

        $stopwords->populate(file_get_contents(__DIR__."/../TestData/IndexItemTest/testIndexItemIndexes_stopwords.txt"));
        
        $index_file_path = __DIR__."/../TestData/IndexItemTest/testIndexItemIndexes_text.txt";
        $index_item = new \Finder\IndexItem($index_file_path, $stopwords, 3);

        $expected_array = [
            1 => [
                "here" => 1,
                "test" => 1,
                "indexitems" => 1
            ],
            2 => [
                "here test" => 1,
                "test indexitems" => 1
            ],
            3 => [
                "here test indexitems" => 1
            ],
        ];

        $this->assertEquals($index_item->content_index, $expected_array);
        $this->assertEquals($index_item->file_path, $index_file_path);
    }
}