<?php

use Spatie\ArrayToXml\ArrayToXml;

class ArrayToXmlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $testArray;

    public function setUp()
    {
        $this->testArray = [
            'Good guy' => [

                'name' => 'Luke Skywalker',
                'weapon' => 'Lightsaber',

            ],
            'Bad guy' => [
                'name' => 'Sauron',
                'weapon' => 'Evil Eye',

            ],
        ];
    }

    /**
     * @test
     */
    public function it_can_convert_an_array_to_xml()
    {
        $expectedXml = '<?xml version="1.0"?>
<root><Good_guy><name>Luke Skywalker</name><weapon>Lightsaber</weapon></Good_guy><Bad_guy><name>Sauron</name><weapon>Evil Eye</weapon></Bad_guy></root>'.PHP_EOL;

        $result = ArrayToXml::convert($this->testArray);

        $this->assertEquals($expectedXml, $result);
    }

    /**
     * @test
     */
    public function it_can_handle_an_empty_array()
    {
        $array = [];

        $expectedXml = '<?xml version="1.0"?>
<root/>'.PHP_EOL;

        $result = ArrayToXml::convert($array);

        $this->assertEquals($expectedXml, $result);
    }

    /**
     * @test
     */
    public function it_can_receive_name_for_the_root_element()
    {
        $rootElementName = 'helloyouluckpeople';

        $array = [];

        $expectedXml = '<?xml version="1.0"?>
<'.$rootElementName.'/>'.PHP_EOL;

        $result = ArrayToXml::convert($array, $rootElementName);

        $this->assertEquals($expectedXml, $result);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_converting_an_array_with_no_keys()
    {
        $this->setExpectedException('DOMException');

        ArrayToXml::convert(['een', 'twee', 'drie'], '', false);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_converting_an_array_with_invalid_characters_key_names()
    {
        $this->setExpectedException('DOMException');

        echo ArrayToXml::convert(['tom & jerry' => 'cartoon characters'], '', false);
    }

    /**
     * @test
     */
    public function it_will_raise_an_exception_when_spaces_should_not_be_replaced_and_a_key_contains_a_space()
    {
        $this->setExpectedException('DOMException');

        ArrayToXml::convert($this->testArray, '', false);
    }

    /**
     * @test
     */
    public function it_can_handle_values_with_special_characters()
    {
        $array =  ['name' => 'this & that'];

        $expectedXml = '<?xml version="1.0"?>
<root><name>this &amp; that</name></root>'.PHP_EOL;

        $result = ArrayToXml::convert($array);

        $this->assertEquals($expectedXml, $result);
    }
}
