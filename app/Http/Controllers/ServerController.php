<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/register',
                'method' => 'POST',
                'body'=> $request->getContent()
            ];
            // echo $data;
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/login',
                'method' => 'POST',
                'body'=> $request->getContent()
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function checkToken(Request $request)
    {
        try {
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/check',
                'method' => 'POST',
                'body'=> $request->getContent()
            ];
            // echo $data;
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/logout',
                'method' => 'POST',
                'body'=> $request->getContent()
            ];
            // echo $data;
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function getDataToken($token)
    {
        try {
            $body = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/check',
                'method' => 'POST',
                'body'=> '{
                    "token": "'.$token.'"
                }'
            ];
            // \dd($body);
            $result = $this->sentRequest($body);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage().'getdataToken');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/profile/update',
                'method' => 'POST',
                'body'=> '{
                    "id": "'.$result['data']['id'].'",
                    "fullname":"'.$request->fullname.'",
                    "email":"'.$request->email.'",
                    "phone":"'.$request->phone.'"
                }'
            ];
            return \json_encode($data);
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function updateUsername(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/profile/update',
                'method' => 'POST',
                'body'=> '{
                    "id": "'.$result['data']['id'].'",
                    "username":"'.$request->username.'"
                }'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }
    
    public function updatePassword(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $data = (object)[
                'url' => env('AUTH_HOST', 'localhost:8201').'/api/profile/update',
                'method' => 'POST',
                'body'=> '{
                    "id": "'.$result['data']['id'].'",
                    "password":"'.$request->password.'"
                }'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function getTransaction(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $parameter = json_decode($request->header('param'), true);
            // return $parameter['id'];
            $param = '"id_user":"'.$result['data']['id'].'"';
            if (isset($parameter['id'])) {
                $param.=', "id": "'.$parameter['id'].'"';
            }
            if (isset($parameter['parent'])) {
                # code...
                $param.=', "id_parent": "'.$parameter['parent'].'"';
            }
            $data = (object)[
                'url' => env('TRAN_HOST', 'localhost:8202').'/api/transactions',
                'method' => 'GET',
                'body'=> '{}',
                'param' => '{'.$param.'}'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function saveTransaction(Request $request)
    {
        # code...
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $body = '"id_user": "'.$result['data']['id'].'",
            "title": "'.$request->title.'",
            "amount": "'.$request->amount.'",
            "type": "'.$request->type.'",
            "status": "'.$request->status.'",
            "date": "'.$request->date.'"';
            if ($request->parent) {
                # code...
                $body.=',
                "id_parent": "'.$request->parent.'"';
            }
            $data = (object)[
                'url' => env('TRAN_HOST', 'localhost:8202').'/api/transactions',
                'method' => 'POST',
                'body'=> '{
                    '.$body.'
                }'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function deleteTransaction(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $data = (object)[
                'url' => env('TRAN_HOST', 'localhost:8202').'/api/transactions/delete',
                'method' => 'POST',
                'body'=> '{
                    "id_user": "'.$result['data']['id'].'",
                    "id": "'.$request->id.'"
                }'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }

    public function updateTransaction(Request $request)
    {
        try {
            //code...
            $result = $this->getDataToken($request->header('token'));
            if ($result['responseCode'] != "200") {
                # code...
                return $result;
            }
            $body = '"id_user": "'.$result['data']['id'].'",
            "id": "'.$request->id.'",
            "title": "'.$request->title.'",
            "amount": "'.$request->amount.'",
            "type": "'.$request->type.'",
            "status": "'.$request->status.'",
            "date": "'.$request->date.'"';
            if ($request->parent) {
                # code...
                $body.=',
                "id_parent": "'.$request->parent.'"';
            }
            $data = (object)[
                'url' => env('TRAN_HOST', 'localhost:8202').'/api/transactions/update',
                'method' => 'POST',
                'body'=> '{
                    '.$body.'
                }'
            ];
            $result = $this->sentRequest($data);
            return json_decode($result, true);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->getResponse(500, $th->getMessage());
        }
    }
}
