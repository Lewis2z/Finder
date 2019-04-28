<?php
use PHPUnit\Framework\TestCase;

class FilesFoldersTest extends TestCase
{
    public function testListDirectoryLists() {
        
        $list = \Finder\FilesFolders::listDirectory(__DIR__."/../TestData/FilesFoldersTest");

        $expected_array = [
            "file1.txt",
            "file2.txt",
            "file3.txt"
        ];

        $this->assertEquals($list, $expected_array);
    }
}