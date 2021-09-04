<?php 

namespace App\Traits;

use App\Models\Employee;
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

}
?>