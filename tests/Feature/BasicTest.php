<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetDetailPenjualanTO()
    {
        $response = $this->json('get', '/penjualan/penjualanorder/getDetailPenjualan/7');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                [
                    's_no'
                ]
            ]
        );
    }
}
