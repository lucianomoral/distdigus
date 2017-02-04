<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function userExists($userid)
    {
        $count;
        $ret;

        $count = User::where("USERID", $userid)->count();

        if ($count > 0)
        {
            $ret = true;
        }
        else
        {
            $ret =  false;
        }

        return $ret;

    }

    public function isPasswordCorrectForUser($userid, $password)
    {
        $count;
        $ret;

        $count = User::where([
                            ["USERID", $userid],
                            ["PASSWORD", $password]
                            ])->count();

        if ($count > 0)
        {
            $ret = true;
        }
        else
        {
            $ret =  false;
        }

        return $ret;
    }

    public function createSession($userid)
    {
        session_start();
        
        $_SESSION['user'] = $userid;
    }

    public function destroySession()
    {
        session_start();

        unset($_SESSION['user']);

        session_destroy();

        return view("login.login");

    }

    public function checkUserLogin(Request $request)
    {
        $responseType; //0: Usuario inexistente; 1: Contraseña incorrecta; 2: Usuario y contraseña ok

        if ($this->userExists($request->user))
        {
            if ($this->isPasswordCorrectForUser($request->user, $request->pass))
            {
                $this->createSession($request->user);
                $responseType = 2;
            }
            else
            {
                $responseType = 1;
            }
        }
        else
        {
            $responseType = 0;
        }

        return response()->json([
            "status" => $responseType
        ]);

    }
    
}