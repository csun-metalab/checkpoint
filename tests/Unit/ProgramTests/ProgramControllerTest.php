<?php

namespace Tests\Feature;

use Tests\TestCase;

use Mockery;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// Requests
use App\Http\Requests\DisplayNameRequest;

// Models
use App\Models\PayPeriodType;

//Contracts
use App\Contracts\ProgramContract;

// Controllers
use App\Http\Controllers\ProgramController;
use App\Models\Program;

class ProgramControllerTest extends TestCase
{
    use DatabaseMigrations;
    private $controller;
    private $utility;
    private $user = null;

    private $classPath = '\App\Http\Controllers\ProgramController';

    public function setUp()
    {
        parent::setUp();
        $this->utility = Mockery::mock(ProgramContract::class);
        $this->controller = new ProgramController($this->utility);

        $this->seed('PassportSeeder');
        $this->seed('PassportSeeder');
        $this->seed('TimeCalculatorTypeSeeder');
        $this->seed('PayPeriodTypeSeeder');
        $this->seed('OrganizationSeeder');
        $this->seed('RoleSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('ProgramSeeder'); // seeds also UserProgram table
        $this->user = $this->createAdminUser();
        $this->actingAs($this->user);
    }

    public function test_program_controller_create()
    {
        $input = ['display_name' => 'display'];
        $request = new DisplayNameRequest($input);

        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('create')
            ->once()
            ->with($orgId, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->create($request);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_all()
    {
        $expectedResponse = [
            [
                "id" => "id",
                "display_name" => "ChecKpoint---",
                "location" => []
            ],
            [
                "id" => "id",
                "display_name" => "Tiana Roberts",
                "location" => [
                    [
                        "id" => "id",
                        "address" => "9061\\tLoyce Prairie\\tKoeppton\\tNevada\\t55935",
                        "lat" => "86.8767400000",
                        "lng" => "-152.9962850000",
                        "radius" => "47.00"
                    ],
                    [
                        "id" => "id",
                        "address" => "5263\\tSaige Mills\\tBreitenbergmouth\\tOhio\\t98666-2646",
                        "lat" => "18.8048100000",
                        "lng" => "173.4162610000",
                        "radius" => "39.00"
                    ]
                ]
            ],
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('all')
            ->once()
            ->andReturn($expectedResponse);

        $response = $this->controller->all();
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_update()
    {
        $input = ['display_name' => 'display'];
        $request = new DisplayNameRequest($input);

        $program = Program::where('organization_id', $this->user->organization_id)->first();


        $expectedResponse = [
            "id" => 'id',
            "display_name" => $input['display_name']
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('update')
            ->once()
            ->with($program, $request['display_name'])
            ->andReturn($expectedResponse);

        $response = $this->controller->update($request, $program);
        $this->assertEquals($expectedResponse, $response);
    }

    public function test_program_controller_delete()
    {
        $program = Program::where('organization_id', $this->user->organization_id)->first();

        $expectedResponse = [
            "message" => 'Program was deleted.',
        ];

        $orgId = $this->user->organization_id;

        $this->utility
            ->shouldReceive('delete')
            ->once()
            ->with($program)
            ->andReturn($expectedResponse);

        $response = $this->controller->delete($program);
        $this->assertEquals($expectedResponse, $response);
    }
}