<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello Patricia');

        $this->get('/hello-again')
            ->assertSeeText('Hello Patricia');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('World Patricia');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'Patricia'])
            ->assertSeeText('Hello Patricia');

        $this->view('hello.world', ['name' => 'Patricia'])
            ->assertSeeText('World Patricia');
    }
}
