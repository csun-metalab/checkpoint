<?php

namespace Tests\Unit\DomainValueObjectsTests;

use Tests\TestCase;
use \App\DomainValueObjects\Log\TimeStamp\TimeStamp;
use \App\Excetptions\TimePuncherExceptions\TimeStamp\GenerateTimeStampFailed;
use \App\DomainValueObjects\UUIDGenerator\UUID;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimeStampTest extends TestCase
{

    public function test_a_timeStamp_is_successfully_created()
    {
        $UUID = new UUID("domainName");
        $timeStamp = new TimeStamp($UUID, "2019-02-01 06:30:44");
        $this->assertInstanceOf(TimeStamp::class, $timeStamp);
    }

    public function test_Invalid_timeStamp_throws_exception()
    {
      $response = new TimeStamp();
      dd($response);
    }
}
