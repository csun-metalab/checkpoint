<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Http\Controllers\LogoutController;
use App\Contracts\LogoutContract;

class LogoutControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(LogoutContract::class);
        $this->controller = new LogoutController($this->retriever);
    }


    /**
     * A Mockery Test for Logout Controller
     *
     * @return json
     */
    public function test_logout_controller_with_mockery()
    {
        $request = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer serializedToken'
        ]);

        $expectedResponse = response()->json("Logout was successful!");

        $this->retriever
            ->shouldReceive('logout')
            ->with($request)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->logout($request);

        $this->assertEquals($expectedResponse, $response);
    }
}
