<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\RegisteringRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $roles = UserRoleEnum::getRolesForRegister();
        return view('auth.register',[
            'roles' => $roles,
        ]);
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();
        //lay thong tin tu nha cung cap dich vu OAuth
        //khi xac nhan dang nhap bang github
        //no se dieu huong ve day
        //kem theo 1 token roi tu token do se lay toan bo thong tin
        
        $user = User::query()
        ->where('email',$data->getEmail())
        ->first();
        //lay dia chi email dau tien tu bang user co email = email của data khi lấy được từ OAuth
        //tim email
        $checkExist = true;
        //mac dinh checkExist = true

        if(is_null($user)){
            //neu khong co email
            $user = new User();
            //tao moi 1 user
            $user->email = $data->getEmail();
            //tao email cua user lấy từ data của OAuth
            $user->role = UserRoleEnum::APPLICANT;
            //mac dinh role la Applicant
            $checkExist = false;
            //neu chua co email checkExits = false
        }
        //roi cap nhap
        $user->name = $data->getName();
        //cap nhap name cho doi tuong user
        $user->avatar = $data->getAvatar();
        //cap nhap avatar cho doi tuong user
        
        
        //luu lai
        
        $role = getRoleByKey($user->role);
        auth()->login($user,true);
        
        
        //lay ra ca $role roi dang nhap
        if($checkExist){
            //neu co $checkExits = true
            //neu role la admin = 0
            $role = getRoleByKey($user->role);
            
            
            return redirect()->route("$role.welcome");
        }
        
        //neu checkExits = false
        return redirect()->route('register');
        //chuyen den trang dang ki
    }

    public function registering(RegisteringRequest $request): RedirectResponse
    {
        $password = Hash::make($request->password);
        //chuan hoa password
        $role = $request->role;
        if(auth()->check()){
            //neu chua co
            User::where('id', auth()->user()->id)
            ->update([
                'password' => $password,
                'role' => $role,
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'role' => $role,
            ]);

            Auth::login($user);
        }
        $role = getRoleByKey($role);
        
        return redirect()->route("$role.welcome");
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route('login');
    }
}
