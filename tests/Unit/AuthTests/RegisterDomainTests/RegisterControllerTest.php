<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Teclearsting\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\Api\Auth\RegisterDomain\RegisterController;
use App\Http\Controllers\Api\Auth\RegisterDomain\Contracts\RegisterContract;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::mock(RegisterContract::class);
        $this->controller = new RegisterController($this->retriever);
    }


    /**
     * A Mockery Test for Register Contoller
     *
     * @return userCreds
     */
    public function test_register_controller_with_mockery()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com"
        ];

        $request = new Request($input);

        $expectedResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
        ];

        $this->retriever
            ->shouldReceive('register')
            ->with($request)
            ->once()->andReturn($expectedResponse);

        $response = $this->retriever->register($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_register_http_call()
    {
        $input = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com",
            "password" => "tes3t@email.com",
            "password_confirmation" => "tes3t@email.com"
        ];

        $response = $this->json('POST', "/api/register", $input);
        $response = $response->getOriginalContent();
        $response = json_encode($response);
        $actualResponse = [
            "name" => "tes3t@email.com",
            "email" => "tes3t@email.com"
        ];
        $actualResponse = json_encode($actualResponse);
        $this->assertEquals($response, $actualResponse);
    }
}
