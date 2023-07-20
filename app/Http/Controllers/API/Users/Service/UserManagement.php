<?php

namespace App\Http\Controllers\API\Users\Service;

/** Core Module - Business login should be setup here. High-Level Module */
class UserManagement {

    public function register_user(Array $user_class_extensions, String $classname) : void {

        foreach( $user_class_extensions as $extension ) {
            if ( $this->get_classname_without_namespace($extension) == $classname ) {
                $extension->register_user();
            }
        }
    }

    public function get_all_users(Array $user_extensions, String $module) : Object {

        $return_data = null;
        foreach( $user_extensions as $extension ) {
            if ( $this->get_classname_without_namespace($extension) == $module ) {
                $return_data = $extension->get_all_users();
            }
        }

        return $return_data;
    }

    /** Just retrieve the class name without having a namespace */
    private function get_classname_without_namespace(Object $class) : String {
        return substr($class::class, (int)strrpos($class::class, '\\') + 1);
    }

}
