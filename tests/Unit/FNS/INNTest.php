<?php


namespace Tests\Unit\FNS;

use App\FNS\Inn;
use Tests\TestCase;

class INNTest extends TestCase
{
    public function testValidate10()
    {
        $inn = new Inn();
        $res = $this->invokeMethod($inn, 'validate10', ['7830002293']);
        $this->assertTrue($res);
        $res = $this->invokeMethod($inn, 'validate10', ['3664069397']);
        $this->assertTrue($res);
        $res = $this->invokeMethod($inn, 'validate10', ['3664069393']);
        $this->assertFalse($res);
    }

    public function testValidate12()
    {
        $inn = new Inn();
        $res = $this->invokeMethod($inn, 'validate12', ['500100732259']);
        $this->assertTrue($res);
        $res = $this->invokeMethod($inn, 'validate12', ['325507450247']);
        $this->assertTrue($res);
        $res = $this->invokeMethod($inn, 'validate12', ['325507450248']);
        $this->assertFalse($res);
    }

    public function testValidate()
    {
        $inn = new Inn();
        $res = $inn->validate('7830002293');
        $this->assertTrue($res);
        $res = $inn->validate('325507450247');
        $this->assertTrue($res);
        $res = $inn->validate('3255074');
        $this->assertFalse($res);
    }
    
    public function testCheck()
    {
        $inn = new Inn();
        
        $res = $inn->check('325507450247');
        
        print_r($res);
    }
}