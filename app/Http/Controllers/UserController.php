<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Psy\Util\Json;

class UserController extends Controller
{

    /**
     * fetch users
     *
     * @param user_id - user id
     *
     * @return Json response
     */
    public function getUsers($user_id=0){
        $users = User::where('id', $user_id)->get();

        if(count($users)>0)
            return response()->json([
                'status' => 'success',
                'data' => $users,
                'message' => '',
            ]);
        else
            return response()->json([
                'status' => 'failed',
                'data' => [],
                'message' => 'No loan found',
            ]);
    }

    /**
     * Create New User
     *
     * name - User Name
     * email - unique email
     * type - user/admin
     * dob - date of birth
     * address
     * profession
     *
     * @return Json response
     */
    public function create(Request $request)
    {

        try{
            $data = $request->all();

            $data['email_verified_at'] = Carbon::now();
            $data['password'] = Hash::make($data['password']);
            $created = User::create($data);

            if(isset($created)){
                return response()->json([
                    'status' => 'success',
                    'data' => $created,
                    'message' => '',
                ]);
            }else{
                return response()->json([
                    'status' => 'failed',
                    'data' => [],
                    'message' => 'Parameter is wrong or missing!',
                ]);
            }
        }catch (\Exception $exception) {
            return response()->json([
                'status' => 'Exception',
                'data' => [],
                'error_code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }

    }

}
