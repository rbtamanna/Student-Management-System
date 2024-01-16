<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRepository
{
    private $id, $password, $user_type, $first_name, $last_name, $email, $dob, $father_name, $mother_name, $image, $birth_certificate, $created_at, $updated_at, $deleted_at;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    public function setFatherName($father_name)
    {
        $this->father_name = $father_name;
        return $this;
    }

    public function setMotherName($mother_name)
    {
        $this->mother_name = $mother_name;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function setBirthCertificate($birth_certificate)
    {
        $this->birth_certificate = $birth_certificate;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
        return $this;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }

    public function getTableData()
   {
       return DB::table('students_info as si')
           ->whereNull('si.deleted_at')
           ->leftJoin('users as u', 'u.id','=','si.user_id')
           ->select('u.first_name','u.last_name','u.email','si.*',DB::raw('date_format(si.dob, "%d-%m-%Y") as dob'))
           ->orderBy('si.id', 'desc')
           ->get();
   }

   public function create()
   {
       DB::beginTransaction();
       try {
           $user = DB::table('users')
               ->insertGetId([
                   'first_name' => $this->first_name,
                   'last_name' => $this->last_name,
                   'email' => $this->email,
                   'user_type' => $this->user_type,
                   'password' => $this->password,
                   'created_at' => $this->created_at,
               ]);
           if($user)
           {
               DB::table('students_info')
                   ->insert([
                       'user_id' => $user,
                       'father_name' => $this->father_name,
                       'mother_name' => $this->mother_name,
                       'dob' => $this->dob,
                       'image' => $this->image,
                       'birth_certificate' => $this->birth_certificate,
                       'created_at' => $this->created_at,
                   ]);
           }
           DB::commit();
           return true;
       } catch (\Exception $exception) {
           DB::rollBack();
           return $exception->getMessage();
       }
   }

    public function update()
    {
        DB::beginTransaction();
        try {
            $updateData = [
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'dob' => $this->dob,
                'updated_at' => $this->updated_at,
            ];
            if ($this->image) {
                $updateData['image'] = $this->image;
            }
            if ($this->birth_certificate) {
                $updateData['birth_certificate'] = $this->birth_certificate;
            }
            $student = DB::table('students_info')
                ->where('id', '=', $this->id)
                ->update($updateData);
            if($student)
            {
                $user_id = (DB::table('students_info')->where('id', '=', $this->id)->select('user_id')->first())->user_id;
                $user = DB::table('users')
                    ->where('id', '=', $user_id)
                    ->update([
                        'first_name' => $this->first_name,
                        'last_name' => $this->last_name,
                        'email' => $this->email,
                        'updated_at' => $this->updated_at,
                    ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
   public function getStudentData()
   {
       return DB::table('students_info as si')
           ->where('si.id','=',$this->id)
           ->leftJoin('users as u', 'u.id', '=', 'si.user_id')
           ->select('u.*', 'si.*', DB::raw('date_format(si.dob, "%d-%m-%Y") as dob'))
           ->first();
   }

   public function delete()
   {
       DB::beginTransaction();
       try {
           $user_id = DB::table('students_info')->where('id', $this->id)->value('user_id');
           DB::table('students_info')->where('id', $this->id)->delete();
           DB::table('users')->where('id', $user_id)->delete();
           DB::commit();
           return true;
       } catch (\Exception $exception) {
           DB::rollBack();
           return $exception->getMessage();
       }
   }
}
