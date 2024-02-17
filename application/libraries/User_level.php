<?php
class User_level
{
    public function level($role) {
        if(!empty($role))
        {
            if($role == 1)
            {
                $user_level = 'admin';
            }
            elseif($role == 2)
            {
                $user_level = 'head';
            }
            elseif($role == 3)
            {
                $user_level = 'employee';
            }
            elseif($role == 4)
            {
                $user_level = 'member';
            }
        }else{
            return false;
        }
        return $user_level;
    }
}