<?php

namespace App\Http\Controllers\API\Users\Repository;

use App\Models\User;

class UsersRepository {

    public function create_user(Array $data) : Object {
        return User::create($data);
    }

    public function get_users(Array $where) : Object {
        return User::where($where);
    }

    /** Update only single user */
    public function update_user(Array $where, Array $data) : Object {
        $user_data = $this->get_users($where)->first();
        $user_data->update($data);
        return $user_data;
    }

    /** Manipulate data in the frontend */
    public function delete_user(Array $where) : void {
        $users = $this->get_users($where)->get();
        foreach($users as $user) {
            $user->delete();
        }
    }

    public function get_deleted_users(Array $where) : Array {
        return User::where($where)->onlyTrashed();
    }

    /** Manipulate the data in the frontend */
    public function restore_deleted_user(Array $where) : void {
        $users = $this->get_users($where)->onlyTrashed();
        foreach( $users as $user ) {
            $user->restore();
        }
    }

}
