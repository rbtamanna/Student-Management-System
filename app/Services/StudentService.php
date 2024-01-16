<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function create($data)
    {
        $img_extension = $data['image']->getClientOriginalExtension();
        $img_file_name = random_int(00001, 99999).'.'.$img_extension;
        $img_file_path = 'student/images/'.$img_file_name;
        Storage::disk('public')->put($img_file_path, file_get_contents($data['image']));
        $bc_extension = $data['birth_certificate']->getClientOriginalExtension();
        $bc_file_name = random_int(00001, 99999).'.'.$bc_extension;
        $bc_file_path = 'student/birth_certificate/'.$bc_file_name;
        Storage::disk('public')->put($bc_file_path, file_get_contents($data['birth_certificate']));
        return $this->studentRepository->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setEmail($data['email'])
            ->setDob(Carbon::createFromFormat('d-m-Y', $data['dob'])->format('Y-m-d'))
            ->setFatherName($data['father_name'])
            ->setMotherName($data['mother_name'])
            ->setImage($img_file_name)
            ->setBirthCertificate($bc_file_name)
            ->setCreatedAt(date('Y-m-d H:i:s'))
            ->setPassword(Hash::make('welcome'))
            ->setUserType(Config::get('variable_constants.user_type.student'))
            ->create();
    }

    public function update($data)
    {
        $img_file_name = '';
        $bc_file_name = '';
        if($data['image'])
        {
            $img_extension = $data['image']->getClientOriginalExtension();
            $img_file_name = random_int(00001, 99999).'.'.$img_extension;
            $img_file_path = 'student/images/'.$img_file_name;
            Storage::disk('public')->put($img_file_path, file_get_contents($data['image']));
        }
        if($data['birth_certificate'])
        {
            $bc_extension = $data['birth_certificate']->getClientOriginalExtension();
            $bc_file_name = random_int(00001, 99999).'.'.$bc_extension;
            $bc_file_path = 'student/birth_certificate/'.$bc_file_name;
            Storage::disk('public')->put($bc_file_path, file_get_contents($data['birth_certificate']));
        }
        return $this->studentRepository->setId($data['id'])
            ->setFirstName($data['first_name'])
            ->setLastName($data['last_name'])
            ->setEmail($data['email'])
            ->setDob(Carbon::createFromFormat('d-m-Y', $data['dob'])->format('Y-m-d'))
            ->setFatherName($data['father_name'])
            ->setMotherName($data['mother_name'])
            ->setImage($img_file_name? $img_file_name:'')
            ->setBirthCertificate($bc_file_name? $bc_file_name:'')
            ->setUpdatedAt(date('Y-m-d H:i:s'))
            ->update();
    }

    public function getStudentData($id)
    {
        return $this->studentRepository->setId($id)->getStudentData();
    }

    public function delete($id)
    {
        return $this->studentRepository->setId($id)->delete();
    }
    public function fetchData()
    {
        $result = $this->studentRepository->getTableData();
        if ($result->count() > 0) {
            $data = array();
            foreach ($result as $key=>$row) {
                $id = $row->id;
                $name = $row->first_name.' '.$row->last_name;
                $email = $row->email;
                $dob = $row->dob;
                $father_name = $row->father_name;
                $mother_name = $row->mother_name;
                $url = asset('storage/student/images/'. $row->image);
                $img = "<td> <img src=\"$url\" class=\"w-100 rounded\" alt=\"user_img\"></td>";
                $birth_certificate = "<a href='" . asset('storage/student/birth_certificate/' . $row->birth_certificate) . "' download>Download</a>";

                $action_btn = "<div class=\"col-sm-6 col-xl-4\">
                                    <div class=\"dropdown\">
                                        <button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" id=\"dropdown-default-secondary\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                            Action
                                        </button>
                                        <div class=\"dropdown-menu font-size-sm\" aria-labelledby=\"dropdown-default-secondary\">";

                $edit_url = url('student/'.$id.'/edit');
                $edit_btn = "<a class=\"dropdown-item\" href=\"$edit_url\">Edit</a>";
                $delete_url = url('student/'.$id.'/delete');
                $delete_btn = "<a class=\"dropdown-item\" href=\"$delete_url\">Delete</a>";

                $action_btn .= " $edit_btn $delete_btn ";

                $action_btn .= "</div>
                                    </div>
                                </div>";
                $temp = array();
                array_push($temp, $key+1);
                array_push($temp, $img);
                array_push($temp, $name);
                array_push($temp, $email);
                array_push($temp, $dob);
                array_push($temp, $father_name);
                array_push($temp, $mother_name);
                array_push($temp, $birth_certificate);
                array_push($temp, $action_btn);
                array_push($data, $temp);
            }
            return json_encode(array('data'=>$data));
        } else {
            return '{
                "sEcho": 1,
                "iTotalRecords": "0",
                "iTotalDisplayRecords": "0",
                "aaData": []
            }';
        }
    }
}
