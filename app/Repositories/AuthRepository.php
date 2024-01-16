<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    private $userId, $password, $email;

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getStudentInfo()
    {
        return DB::table('students_info')
            ->whereNull('deleted_at')
            ->where('id', '=', $this->userId)
            ->get();
    }


    public function getBasicInfo()
    {
        if($this->userId == 1) {
            return DB::table('basic_info as bi')
                ->whereNull('bi.deleted_at')
                ->where('bi.user_id', '=', $this->userId)
                ->select('bi.branch_id', 'bi.department_id', 'bi.designation_id', 'bi.role_id')
                ->get()
                ->first();
        } else {
            return DB::table('basic_info as bi')
                ->leftJoin('designations as d', function ($join) {
                    $join->on('d.id', '=', 'bi.designation_id');
                })
                ->whereNull('bi.deleted_at')
                ->where('bi.user_id', '=', $this->userId)
                ->select('bi.branch_id', 'bi.department_id', 'bi.designation_id', 'bi.role_id', 'd.name')
                ->get()
                ->first();
        }
    }
    public function changePassword()
    {
        return DB::table('users')
            ->where('id','=',auth()->user()->id)
            ->update([
                'password'=> Hash::make($this->password)
            ]);
    }

    public function forgetPassword()
    {
        return DB::table('users')
            ->where('email','=',$this->email)
            ->update([
                'password'=> Hash::make($this->password)
            ]);
    }
    public function getUserPassword()
    {
        $user = DB::table('users')->where('id', '=',auth()->user()->id)->select('password')->first();
        return $user->password;
    }
}
