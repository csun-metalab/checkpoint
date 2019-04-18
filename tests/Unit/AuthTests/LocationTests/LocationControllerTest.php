<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Teclearsting\WithFaker;
// use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use App\DomainValueObjects\Location\Address;
 
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\LocationController;
use App\Contracts\LocationContract;

class LocationControllerTest extends TestCase
{
  use DatabaseMigrations;
  private $controller;
  private $retriever;

  public function setUp()
  {
        parent::setUp();
        $this->retriever = Mockery::mock(LocationContract::class);
        $this->controller = new LocationController($this->retriever);
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
  }

  public function test_update_organization_location()
  {
    $request = [
        'longitude' => 42.09,
        'latitude' => 48.03,
        'radius' => 5,
        'address_number' => "9423 #A",
        'street' => "Reseda Blvd",
        'city' => "Northridge",
        'state' => "California",
        'zip' => "91324",
    ];

    $latitude = $request['latitude'];
    $longitude = $request['longitude'];
    $radius = $request['radius'];

    $address = new Address(
        $request['address_number'],
        $request['street'],
        $request['city'],
        $request['state'],
        $request['zip']
      );

    $expectedResponse = [];

    $this->retriever
        ->shouldReceive('updateOrganizationLocation')
        ->with($address, $longitude, $latitude, $radius)
        ->once()
        ->andReturn($expectedResponse);

    $response = $this->retriever->updateOrganizationLocation($address, $longitude, $latitude, $radius);

    $this->assertEquals($expectedResponse, $response);
  }

  public function test_update_project_location()
  {
    $request= [
      'id' => "some_project_id",
      'longitude' => 42.09,
      'latitude' => 48.03,
      'radius' => 5,
      'address_number' => "9423 #A",
      'street' => "Reseda Blvd",
      'city' => "Northridge",
      'state' => "California",
      'zip' => "91324",
    ];
    
    $latitude = $request['latitude'];
    $longitude = $request['longitude'];
    $radius = $request['radius'];
    $id = $request['id'];

    $address = new Address(
        $request['address_number'],
        $request['street'],
        $request['city'],
        $request['state'],
        $request['zip']
      );
    
    $expectedResponse = [];
    $this->retriever
        ->shouldReceive('updateProjectLocation')
        ->with($address, $longitude, $latitude, $radius, $id)
        ->once()
        ->andReturn($expectedResponse);
    
    $response = $this->retriever->updateProjectLocation($address, $longitude, $latitude, $radius, $id);

    $this->assertEquals($expectedResponse, $response);
  }
}