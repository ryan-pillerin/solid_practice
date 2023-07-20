<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

use App\Http\Controllers\API\Users\Service\UserManagement as UserManagement;
use App\Http\Controllers\API\Users\Service\Classes\AdminUsers;
use App\Http\Controllers\API\Users\Service\Classes\ClientUsers;

class UsersController extends Controller
{

    private $user_management;

    function __construct(UserManagement $user_management) {
        $this->user_management = $user_management;
    }

    public function register_user(Request $request) {

        try {

            $validator = Validator::make($request->data, [
                'name'  => 'required|max:150|min:0',
                'email' => 'required|max:100|min:0',
                'password' => 'required|max:100|min:4',
            ]);

            if ( $validator->fails() ) {
                return response()->json([
                    'response' => false,
                    'data' => $validator
                ], 400);
            }

            /** Process Registration - The member_type parameter will choose what class to use for certain registration */
            /**
             * Data Structure for the Registration
             * {
             *  'member_type': 'AdminUsers|ClientUsers',
             *  'data': {
             *      'name': 'Name',
             *      'email': 'Email',
             *      'password': 'password'
             *  }
             * }
             */
            $this->user_management->register_user([
                new AdminUsers($request->data),
                new ClientUsers($request->data),
            ], $request->classname);

            return response()->json([
                'response' => true,
                'data' => 'Successfully registered!'
            ], 200);

        } catch (Exception $ex) {
            return $this->get_exception($ex);
        }

    }

    /**
     * Request Parameter: { module: "AdminUsers|ClientUsers" } - This is required to select what type of module to execute.
     * Other parameters, please look at the API Route. Feel free to change or improve the concept. So far, the code is now
     * implementing SOLID principle particularly Single Responsibility and Open-closed Principles.
     * */
    public function get_all_users(Request $request, Int $id = null) {
        try {

            $module = $request->module;

            $response = $this->user_management->get_all_users([
                new AdminUsers([]),
                new ClientUsers($id)
            ], $module);

            return response()->json([
                'response'  => true,
                'data'      => $response
            ], 200);

        } catch (Exception $ex) {
            return $this->get_exception($ex);
        }
    }

    private function get_exception(Exception $ex) {
        return response()->json([
            'response' => false,
            'data' => [
                'message'       => $ex->getMessage(),
                'code'          => $ex->getCode(),
                'file'          => $ex->getFile(),
                'line'          => $ex->getLine(),
                'trace'         => $ex->getTrace(),
                'previous'      => $ex->getPrevious(),
                'traceAsString' => $ex->getTraceAsString(),
            ]
        ], 500);
    }
}
