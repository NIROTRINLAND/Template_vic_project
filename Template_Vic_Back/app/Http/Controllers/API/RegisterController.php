<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



class RegisterController extends BaseController
{
    // Register api
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // éviter doublons
            'password' => 'required',
            'c_password' => 'required|same:password',
            'photos' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
    
        // ✅ Upload de l'image si elle existe
        if ($request->hasFile('photos')) {
            // stocker dans storage/app/public/photos
            $path = $request->file('photos')->store('photos', 'public');
    
            // créer un lien public vers l'image
            $input['photos'] = asset('storage/' . $path);
        }
    
        $user = User::create($input);
    
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        $success['photos'] = $user->photos;
        $success['user'] = $user; // ✅ renvoyer tout l’utilisateur
        return $this->sendResponse($success, 'User register successfully.');
    }
    

    // Login api
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}