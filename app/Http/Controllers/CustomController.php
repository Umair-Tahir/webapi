<?php

namespace App\Http\Controllers;

use App\Mail\Verification;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomController extends Controller
{

    function createPartner(Request $request){
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
                'r_name' => 'required',
                'mobile' => 'required',
                'address' => 'required',
            ]);
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->device_token = $request->input('device_token', '');
            $user->password = Hash::make($request->input('password'));
            $user->api_token = str_random(60);
            $user->status = "Inactive";
            $user->verify_token = uniqid();
            $user->save();
            $user->assignRole(3);

            $restaurant = new Restaurant();
            $restaurant->name = $request->input('r_name');
            $restaurant->mobile = $request->input('mobile');
            $restaurant->latitude = "56.1304";
            $restaurant->longitude = "106.3468";
            $restaurant->address = $request->input('address');
            $restaurant->save();

            DB::table("user_restaurants")->insert([
                "user_id" => $user->id,
                "restaurant_id" => $restaurant->id,
            ]);


            if (copy(public_path('images/avatar_default.png'), public_path('images/avatar_default_temp.png'))) {
                $user->addMedia(public_path('images/avatar_default_temp.png'))->withCustomProperties(['uuid' => bcrypt(str_random())])->toMediaCollection('avatar');
            }
            Mail::to($user)->send(new Verification($user));

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }

        return $this->sendResponse($user, 'User retrieved successfully');
    }

    public function verify(Request $request){
        $message = "sorry invalid token";
        $code = $request->get('token');
        $find = User::where("verify_token", $code)->count();
        if($find > 0 ){
            $user = User::where("verify_token", $code)->first();
            $update = User::find($user->id);
            $update->status = "Active";
            $update->save();
            $message = "Your account is activated";
        }
        return view("auth.verify", [
            "message" => $message
        ]);
    }


}
