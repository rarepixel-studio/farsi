<?php

namespace OpiloTest\Farsi;

use Opilo\Farsi\MiscHelpers;
use PHPUnit_Framework_TestCase;

class MiscHelpersTest extends PHPUnit_Framework_TestCase
{
    public function test_search()
    {
        $this->assertEquals(0, MiscHelpers::binarySearch(0, [0, 1]));
        $this->assertEquals(1, MiscHelpers::binarySearch(1, [0, 2]));
        $this->assertEquals(2, MiscHelpers::binarySearch(2, [0, 1]));
        $this->assertEquals(0, MiscHelpers::binarySearch(-1, [0, 1]));
        $this->assertEquals(1, MiscHelpers::binarySearch(1, [0, 1]));

        $this->assertEquals(0, MiscHelpers::binarySearch(0, [0, 1, 2, 3, 4, 5]));
        $this->assertEquals(1, MiscHelpers::binarySearch(1, [0, 2, 5, 6, 7]));
        $this->assertEquals(5, MiscHelpers::binarySearch(10, [0, 2, 5, 6, 7]));
    }
}
