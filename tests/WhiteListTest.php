<?php

namespace Padosoft\LaravelComposerSecurity\Test;


use Padosoft\LaravelComposerSecurity\WhiteList;


class WhiteListTest extends TestBase
{

    /** @test */
    public function testAdjustWhiteList()
    {
        $arr = WhiteList::adjustWhiteList('');
        $this->assertTrue(is_array($arr) && count($arr)==0);

        $arr = WhiteList::adjustWhiteList('uno/due/tre/');
        $this->assertTrue(is_array($arr) && count($arr)==1 && $arr[0]=='uno/due/tre/');

        $arr = WhiteList::adjustWhiteList('uno/due/tre');
        $this->assertTrue(is_array($arr) && count($arr)==1);
        $this->assertTrue($arr[0]=='uno/due/tre/');

        $arr = WhiteList::adjustWhiteList('uno/due/tre,quattro/cinque/sei/');
        $this->assertTrue(is_array($arr) && count($arr)==2);
        $this->assertTrue($arr[0]=='uno/due/tre/');
        $this->assertTrue($arr[1]=='quattro/cinque/sei/');
    }
}
