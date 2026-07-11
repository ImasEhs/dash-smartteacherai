<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Hash;
use Session;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        
        try
        {
            $googleUser = Socialite::driver('google')->stateless()->user();
        
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'username' => $googleUser->getEmail(),
                    'password' => bcrypt(rand(0 , 9999))
            ]);
    
    
            $url = "https://admin.smartteacherai.id/api/v1";
    
            $googleAccessToken = $googleUser->token;
    
            $loginResponse = \Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                ])
                ->post($url. '/auth/login-social/google', [
                    'access_token' => $googleAccessToken,
            ]);
    
            if (!$loginResponse->successful()) 
            { 
                dd("Gagal login ke LMS. Response API:", $loginResponse->json());
                // return redirect('/login')->with('error', 'Gagal login ke LMS :' . $loginResponse->json('message'));
            }
            
            $data = $loginResponse->json();
            
            
            if($data){
                Session::put('id' , $googleUser->getId());
                Session::put('name' , $googleUser->getName());
                Session::put('email' , $googleUser->getEmail());
                Session::put('lms_token' , $data['data']['access_token']);
        
                return redirect('/dashboard'); 
            }
        }
        catch(\Throwable $e)
        {
            // return redirect('/')->with('error' , $e);
            
            return $e;
        }
        
        
    }

    
}
