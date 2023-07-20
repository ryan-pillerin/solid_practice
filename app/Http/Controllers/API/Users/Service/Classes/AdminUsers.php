<?php

namespace App\Http\Controllers\API\Users\Service\Classes;

use Hash;

use App\Http\Controllers\API\Users\Repository\UsersRepository;
use App\Http\Controllers\API\Users\Service\Interfaces\AdminUsersInterface;

/** Extension Module - Sub-business logic should be put here. Low-level Module */
class AdminUsers implements AdminUsersInterface {

    private $user_repo;
    private $data = [];

    /** The mixed data type is set the parameter any type of variable to accept but should be controlled. */
    function __construct(Mixed $data = null) {
        $this->user_repo = new UsersRepository();
        $this->data = $data;
    }

    public function register_user() : void {
        $this->data['password'] = Hash::make($this->data['password']);
        $this->user_repo->create_user($this->data);
    }

    public function get_all_users() : Object {
        return $this->user_repo->get_users($this->data)->get();
    }
}
