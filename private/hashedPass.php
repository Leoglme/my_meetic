<?php
class hashedPass
{

    public function hash($pwd)
    {
        return password_hash($pwd, PASSWORD_DEFAULT);

    }

    public function samePwd($pwd, $hsh){
        if (password_verify($pwd, $hsh)) {
            return false;
        } else {
            return true;
        }
    }
}