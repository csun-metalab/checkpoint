<?php
namespace App\Contracts;

interface TimeSheetContract
{
    public function getTimeSheetbyDate($date);
    public function getCurrentTimeSheet();
}
