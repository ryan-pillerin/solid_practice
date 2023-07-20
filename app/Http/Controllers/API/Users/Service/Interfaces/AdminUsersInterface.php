<?php

namespace App\Http\Controllers\API\Users\Service\Interfaces;

interface AdminUsersInterface {
    public function register_user(): void;
    public function get_all_users(): Object;
}
