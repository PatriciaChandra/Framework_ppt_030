<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Patricia')
            ->assertSeeText('Hello Patricia');

        $this->post('/input/hello', [
            'name' => 'Patricia'
        ])->assertSeeText('Hello Patricia');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Patricia",
                "last" => "chandra"
            ]
        ])->assertSeeText("Hello Patricia");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "Patricia",
                "last" => "chandra"
            ]
        ])->assertSeeText("name")->assertSeeText("first")
            ->assertSeeText("last")->assertSeeText("Patricia")
            ->assertSeeText("chandra");
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30000000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 15000000
                ]
            ]
        ])->assertSeeText("Apple Mac Book Pro")
            ->assertSeeText("Samsung Galaxy S10");
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])->assertSeeText('Budi')->assertSeeText("true")->assertSeeText("1990-10-10");
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Patricia",
                "middle" => "Eka Candra",
                "last" => "chandra"
            ]
        ])->assertSeeText("Patricia")->assertDontSeeText("Eka Candra");
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "Patricia",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("Patricia")->assertSeeText("rahasia")
            ->assertDontSeeText("admin");
    }


    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "Patricia",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("Patricia")->assertSeeText("rahasia")
            ->assertSeeText("admin")->assertSeeText("false");
    }
}
