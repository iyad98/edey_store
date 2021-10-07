<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 6:08 م
 */

namespace App\Repository;


use App\Models\Admin;

class AdminRepository
{

    public $admin;
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function __call($name, $arguments)
    {
        return $this->admin->$name(...$arguments);
    }

    public function addAdmin($name , $username , $email , $phone , $password ,$path , $role) {
        $this->admin->admin_name = $name;
        $this->admin->admin_username = $username;
        $this->admin->admin_email = $email;
        $this->admin->admin_phone = $phone;
        $this->admin->password = bcrypt($password);
        $this->admin->admin_image = $path;
        $this->admin->admin_role = $role;
        $this->admin->save();

        return $this->admin;
    }
    public function updateAdmin($obj ,$name , $username , $email , $phone , $password , $path , $role) {
        $obj->admin_name = $name;
        $obj->admin_username = $username;
        $obj->admin_email = $email;
        $obj->admin_phone = $phone;
        if(!is_null($password)) {
            $obj->password = bcrypt($password);
        }
        $obj->admin_image = $path;
        $obj->admin_role = $role;
        $obj->update();
       

        return $obj;
    }
    public function changeStatus($obj) {

        if($obj->admin_status == 0) {
            $obj->admin_status = 1;
        }else {
            $obj->admin_status = 0;
        }
        $obj->update();

        return $obj;
    }
    public function deleteAdmin($obj) {

        $obj->delete();
        return $obj;
    }
    public function changePassword($obj , $password) {
        $obj->password = $password;
        $obj->update();

        return $obj;
    }


    public function getAdmins($status = -1 ) {
        $query = $this;
        if($status != -1) {
            $query = $query->where('admin_status' , '=' , $status);
        }
        return $query->select('*');
    }
}