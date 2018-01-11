<?php

class PU2Test extends \PHPUnit\Framework\TestCase {
    public function test_this() {
        $key = 'test';
        $value = 'test';
        print_r('some stuff');
        $this->assertEquals($key, $value, 'test_this() failed!');
    }

    public function test_this_too() {
        $key = 'test';
        $value = 'test';
        print_r('some stuff');
        $this->assertEquals($key, $value, 'test_this_too() failed!');
    }
}

?>
