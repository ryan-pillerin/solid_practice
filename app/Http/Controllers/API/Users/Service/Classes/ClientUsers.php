<?php

namespace App\Http\Controllers\API\Users\Service\Classes;

use Hash;

use App\Http\Controllers\API\Users\Service\Interfaces\AdminUsersInterface;
use App\Http\Controllers\API\Users\Repository\UsersRepository;

/** Extension Module - Sub-business logic should be put here. Low-level Module */
class ClientUsers implements AdminUsersInterface {

    private $user_repo;
    private $data = [];

    function __construct(Mixed $data = null) {
        $this->user_repo = new UsersRepository();
        $this->data = $data;
    }

    public function register_user() : void {
        $this->data['password'] = Hash::make($this->data['password']);
        $this->user_repo->create_user($this->data);
    }

    public function get_all_users() : Object {
        return $this->user_repo->get_users([
            ['id', $this->data]
        ])->get();
    }

}
