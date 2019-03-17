<?php 

namespace App\Http\Controllers\Api\TimeLog\ClockOutDomain\Services;

// Auth
use Illuminate\Support\Facades\Auth;

// Contracts 
use App\Http\Controllers\Api\TimeLog\ClockOutDomain\Contracts\ClockOutContract;
use App\Http\Controllers\Api\TimeLog\Logic\Contracts\ClockOutLogicContract;

class ClockOutService implements ClockOutContract
{

    protected $clockOutLogic;

    public function __construct(ClockOutLogicContract $clockOutLogicUtility)
    {
        $this->clockOutLogicUtility = $clockOutLogicUtility;
    }

    public function clockOut(string $timeStamp, string $logUuid): array
    {
        $user = Auth::user();

        $timelog = $this->clockOutLogicUtility->getTimeLog($user->id, $logUuid);
        
        $clockOut = $this->clockOutLogicUtility->getClockOut($timeStamp);

        return $this->clockOutLogicUtility->appendClockOutToTimeLog($timelog, $clockOut, $timeStamp);
    }

}

 