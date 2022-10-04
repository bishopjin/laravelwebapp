<?php 
namespace App\Http\Controllers\Traits;

use Carbon\Carbon;
use App\Models\PayrollWorkSchedule;

trait PayrollAdmin
{
	public function getTardiness($schedule_in, $actual_in)
  {
  	return Carbon::parse($schedule_in)->diffInMinutes(Carbon::parse($actual_in), false);
  }

  public function getSchedMnhr($workSchedID)
  {
    $workSched = PayrollWorkSchedule::find($workSchedID);
    $wsArr = explode('-', $workSched->schedule);

    return (Carbon::parse(trim($wsArr[1]))->diffInMinutes(Carbon::parse(trim($wsArr[0]))) - 60);;
  }

  public function getNightDiff($time_out)
  {
    $nghDff1 = 0;
    $nghDff2 = 0;
    /* check if night diff 10 to 12 mn */
    if (strtotime($time_out) >= strtotime('22:00:00') AND strtotime($time_out) <= strtotime('23:59:00')) {
      $nghDff1 = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse('22:00:00')));
    }

    if (strtotime($time_out) >= strtotime('24:00:00') AND strtotime($time_out) <= strtotime('06:00:00')) {
			$nghDff2 = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse('24:00:00')));;
    }
    return ($nghDff1 + $nghDff2);
  }

  public function getTotalMnhr($time_in, $lunch_out, $lunch_in, $time_out, $schedMH)
  {
		$hstart = (Carbon::parse($lunch_out)->diffInMinutes(Carbon::parse($time_in), true));
		$hend = (Carbon::parse($time_out)->diffInMinutes(Carbon::parse($lunch_in), true));

		$manhr = ($hstart + $hend);

		if (($hstart + $hend) > ($schedMH / 2)) {
			$manhr -= 60;
		}
		return $manhr;
  }
}