<?php 

namespace App\Traits;

use App\Models\Employee;
use App\Models\ScratchAndWinTobaccoShop;
use App\Models\User;

trait employeeHandle{

    function employeeAddingUserInfo($datas)
    {
        
        foreach( $datas as $data)
        {
            if( !$data->pivot->employee_id ) continue;
            $data->user =User::find( Employee::find($data->pivot->employee_id)->user_id );
        }
        return $datas;
    }

    function getScratchAndWinSoldByEmployee($employee)
    {
        $scratchAndWinSold = ScratchAndWinTobaccoShop::select('quantity')->where('employee_id',$employee->id)->where('quantity','<', 0)->get();
        $sumOfScratchAndWinSold = 0;
        foreach( $scratchAndWinSold as $scratchAndWin)
        {
            $sumOfScratchAndWinSold += $scratchAndWin->quantity;
        }

        return $sumOfScratchAndWinSold;
    }

}
?>