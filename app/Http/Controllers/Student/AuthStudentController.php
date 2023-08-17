<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthStudentController extends Controller
{
    protected function uploadImage($request) {
		$image = $request->file('photo');
		$imageName = time().$image->getClientOriginalName();
		$image->move(public_path('images'),$imageName);
        $imageUrl = asset('images/'.$imageName);
		return $imageUrl;
	}
    public function register(Request $request) {
        $credentials = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone_number'=>'required',
            'password' => 'required',
        ]);
        $imageUrl = '';
        if ($request->hasFile('photo')) {
            $imageUrl = $this->uploadImage($request);
        }
        $credentials['photo'] = $imageUrl;
        $user = User::query()->create([
            'role_id' => 4,
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'email_verified_at' => now()
        ]);
         $student = $user->students()->create($credentials);

        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user['token_type'] = 'Bearer';
        $response = response()->json([
            'status'=>200,
            'massage' => 'registeration donr seccesfully',
            'data' => $student,
            'token' => $token,
            'role'=>'student'
        ]);
        return $response;
    }
}
