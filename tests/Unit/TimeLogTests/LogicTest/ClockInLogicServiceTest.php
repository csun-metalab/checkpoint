<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// DomainValue Objects
use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\ClockIn\ClockIn;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;

// Models
use App\Models\TimeSheets;

use App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService;

class ClockInLogicServiceTest extends TestCase
{

    use DatabaseMigrations;
    private $clockInLogicUtility;
    private $service;
    private $classPath = 'App\Http\Controllers\Api\TimeLog\Logic\Services\ClockInLogicService';
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->service = new ClockInLogicService();
        $this->seed('OrgnaizationSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('TimeSheetSeeder');
        $this->user = \App\User::where('id', 1)->first();
        $this->actingAs($this->user);
    }

    public function test_verifyUserHasNotYetTimeLogged_passes()
    {
        $response = $this->service->verifyUserHasNotYetTimeLogged($this->user->id);

        $this->assertInternalType('bool', $response);
        $this->assertEquals(true, $response);
    }

    public function test_getTmeSheetId_passes()
    {
        $userId = 1;
        $timeSheet = TimeSheets::where('user_id', $userId)->first();

        $function = 'getTimeSheetId';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $userId);

        $this->assertEquals($timeSheet->id, $response);
        $this->assertInternalType('string', $response);
    }

    public function test_getClockIn_passes()
    {
        $timeStamp =  "2019-02-01 09:30:44";

        $function = 'getClockIn';
        $method = $this->get_private_method($this->classPath, $function);
        $response = $method->invoke($this->service, $timeStamp);

        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockIn\ClockIn', $response);
    }

    public function test_getTimeLogParam_passes()
    {
        $timeStamp =  "2019-02-01 06:30:44";

        $response = $this->service->getTimeLogParam($this->user->id, $timeStamp);

        $this->assertArrayHasKey('clockIn', $response);
        $this->assertArrayHasKey('uuid', $response);
        $this->assertArrayHasKey('timeSheetId', $response);
        $this->assertInternalType('string', $response['uuid']);
        $this->assertInstanceOf('App\DomainValueObjects\TimeLog\ClockIn\ClockIn', $response['clockIn']);
    }

    public function test_createClockInEntry_passes()
    {
        $timeStampString = "2019-02-01 06:30:44";

        $timeStamp = new TimeStamp(new UUID('timeStamp'), $timeStampString);
        $clockIn = new ClockIn(new UUID('clockIn'), $timeStamp);

        $timeSheetId = "uuid";
        $logUuid = "uuid";

        $response = $this->service->createClockInEntry($logUuid, $this->user->id, $timeSheetId, $clockIn, $timeStampString);
        $this->assertArrayHasKey('message_success', $response);
        $this->assertArrayHasKey('timeSheet_id', $response);
        $this->assertArrayHasKey('log_uuid', $response);
        $this->assertArrayHasKey('time_stamp', $response);
        $this->assertInternalType('string', $response['timeSheet_id']);
        $this->assertInternalType('string', $response['time_stamp']);
        $this->assertInternalType('string', $response['log_uuid']);
        $this->assertInternalType('string', $response['message_success']);
    }
}
