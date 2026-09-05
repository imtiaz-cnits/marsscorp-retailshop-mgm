<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPMail;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {
        try {
            $img = $request->file('img');
            $t = time();
            $file_name = $img->getClientOriginalName();
            $img_name = "{$t}-{$file_name}";
            $img_url = "uploads/user-img/{$img_name}";
            $img->move(public_path('uploads/user-img'), $img_name);

            $user = new User([
                'img_url' => $img_url,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'), // Set the role based on user input
                'status' => $request->input('status'), // Default status to pending
            ]);

            $user->save();

            return response()->json(['status' => 'success', 'message' => 'User Registration Successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    // function UserLogin(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'email' => 'required|string|email|max:50',
    //             'password' => 'required|string|min:3'
    //         ]);

    //         $user = User::where('email', $request->input('email'))->first();

    //         if (!$user || !Hash::check($request->input('password'), $user->password)) {
    //             return response()->json(['status' => 'failed', 'message' => 'Invalid User']);
    //         }

    //         $token = $user->createToken('authToken')->plainTextToken;
    //         return response()->json(['status' => 'success', 'message' => 'Login Successful', 'token' => $token]);

    //     } catch (Exception $e) {
    //         return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //     }
    // }


    public function UserLogin(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'password' => 'required|string|min:3'
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(['status' => 'failed', 'message' => 'Invalid User']);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            // Include role and permissions in the response
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful',
                'token' => $token,
                'role' => $user->role,
                'permissions' => $user->permissions ? json_decode($user->permissions, true) : null
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
        // try {
        //     $request->validate([
        //         'email' => 'required|email|max:50',
        //         'password' => 'required|string|min:3',
        //     ]);

        //     $user = User::where('email', $request->email)->first();

        //     if (!$user || !Hash::check($request->password, $user->password)) {
        //         return response()->json(['status' => 'failed', 'message' => 'Invalid credentials']);
        //     }

        //     // Generate OTP
        //     $otp = rand(100000, 999999);
        //     $user->otp = $otp;
        //     $user->otp_expires_at = Carbon::now()->addMinutes(5);
        //     $user->save();

        //     // Send OTP via email
        //     Mail::to($user->email)->send(new SendOtpMail($otp));

        //     return response()->json([
        //         'status' => 'otp_sent',
        //         'message' => 'OTP sent to your email. Please verify.',
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        // }
    }

    public function SendOTPCode(Request $request)
    {

        try {

            $request->validate([
                'email' => 'required|string|email|max:50'
            ]);

            $email = $request->input('email');
            $otp = rand(1000, 9999);
            $count = User::where('email', '=', $email)->count();

            if ($count == 1) {
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email', '=', $email)->update(['otp' => $otp]);
                return response()->json(['status' => 'success', 'message' => '4 Digit OTP Code has been send to your email !']);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Invalid Email Address'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    //     public function VerifyOTP(Request $request)
    // {
    //     try {
    //         // Validate the request input
    //         $request->validate([
    //             'email' => 'required|string|email|max:50',
    //             'otp' => 'required|string|min:6|max:6', // Ensure OTP is exactly 6 digits
    //         ]);

    //         $email = $request->input('email');
    //         $otp = $request->input('otp');

    //         // Find the user based on email
    //         $user = User::where('email', '=', $email)->first();

    //         // Check if user exists
    //         if (!$user) {
    //             return response()->json(['status' => 'fail', 'message' => 'User not found']);
    //         }

    //         // Check if OTP matches
    //         if ($user->otp !== $otp) {
    //             return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
    //         }

    //         // Check if OTP has expired
    //         if (Carbon::now()->gt($user->otp_expires_at)) {
    //             return response()->json(['status' => 'fail', 'message' => 'OTP expired']);
    //         }

    //         // Clear OTP after successful verification
    //         $user->otp = null;
    //         $user->otp_expires_at = null;
    //         $user->save();

    //         // Create Sanctum token for authenticated user
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP Verification Successful',
    //             'token' => $token,
    //             'role' => $user->role // If you want to include the user's role
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('OTP Verification failed: ' . $e->getMessage()); // Log error for debugging
    //         return response()->json(['status' => 'fail', 'message' => 'An error occurred during OTP verification']);
    //     }
    // }



    //   public function VerifyOTP(Request $request)
    //     {

    //         try {
    //             $request->validate([
    //                 'email' => 'required|string|email|max:50',
    //                 'otp' => 'required|string|min:4'
    //             ]);

    //             $email = $request->input('email');
    //             $otp = $request->input('otp');

    //             $user = User::where('email', '=', $email)->where('otp', '=', $otp)->first();

    //             if (!$user) {
    //                 return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
    //             }

    //             // CurrentDate-UpdatedTe=4>Min

    //             User::where('email', '=', $email)->update(['otp' => '0']);

    //             $token = $user->createToken('authToken')->plainTextToken;
    //             return response()->json(['status' => 'success', 'message' => 'OTP Verification Successful', 'token' => $token]);

    //         } catch (Exception $e) {
    //             return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
    //         }
    //     }





    public function VerifyOTP(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|string|email|max:50',
                'otp' => 'required|string|min:6'
            ]);

            $email = $request->input('email');
            $otp = $request->input('otp');

            $user = User::where('email', '=', $email)->where('otp', '=', $otp)->first();

            if (!$user) {
                return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
            }

            // CurrentDate-UpdatedTe=4>Min

            User::where('email', '=', $email)->update(['otp' => '0']);

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['status' => 'success', 'message' => 'Login Successful', 'token' => $token]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    // public function VerifyOTP(Request $request)
    // {
    //     try {
    //         // Validate the request input
    //         $request->validate([
    //             'email' => 'required|string|email|max:50',
    //             'otp' => 'required|string|min:6|max:6', // Ensure OTP is exactly 6 digits
    //         ]);

    //         $email = $request->input('email');
    //         $otp = $request->input('otp');

    //         // Find the user based on email
    //         $user = User::where('email', '=', $email)->first();

    //         // Check if user exists
    //         if (!$user) {
    //             return response()->json(['status' => 'fail', 'message' => 'User not found']);
    //         }

    //         // Check if OTP matches
    //         if ($user->otp !== $otp) {
    //             return response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
    //         }

    //         // Check if OTP has expired
    //         if (Carbon::now()->gt($user->otp_expires_at)) {
    //             return response()->json(['status' => 'fail', 'message' => 'OTP expired']);
    //         }

    //         // Clear OTP after successful verification
    //         $user->otp = null;
    //         $user->otp_expires_at = null;
    //         $user->save();

    //         // Create Sanctum token for authenticated user
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP Verification Successful',
    //             'token' => $token,
    //             'role' => $user->role // If you want to include the user's role
    //         ]);

    //     } catch (\Exception $e) {
    //         // Log the exception message for debugging purposes
    //         Log::error('OTP Verification failed: ' . $e->getMessage()); // Log the detailed error

    //         // Return a more detailed error message to the user
    //         return response()->json([
    //             'status' => 'fail',
    //             'message' => 'An error occurred during OTP verification. Please check the logs for details.'
    //         ]);
    //     }
    // }


    function ResetPassword(Request $request)
    {

        try {
            $request->validate([
                'password' => 'required|string|min:3'
            ]);
            $id = Auth::id();
            $password = $request->input('password');
            User::where('id', '=', $id)->update(['password' => Hash::make($password)]);
            return response()->json(['status' => 'success', 'message' => 'Request Successful']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }


    public  function UserProfile(Request $request)
    {
        return Auth::user();
    }

    public function UsersProfile(Request $request)
    {
        $user = Auth::user();
        $perms = $user->permissions ? json_decode($user->permissions, true) : null;

        return response()->json([
            'id'          => $user->id,
            'name'        => $user->name ?? 'User',
            'email'       => $user->email ?? '',
            'role'        => strtolower($user->role ?? 'user'),
            'mobile'      => $user->mobile ?? '',
            'img_url'     => $user->img_url ? asset($user->img_url) : asset('backend/assets/img/profile-img.png'),
            'permissions' => $perms,
        ]);
    }


    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'mobile' => 'required|string|max:20',
                'password' => 'nullable|string|min:6|confirmed',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Max 1MB
            ]);

            $user = Auth::user();
            $user->name = $request->input('name');
            $user->mobile = $request->input('mobile');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$user->id}-{$t}-{$file_name}";
                $img_url = "uploads/user-img/{$img_name}";

                // Upload the file
                $img->move(public_path('uploads/user-img'), $img_name);

                // Delete old image if it exists
                if ($user->img_url && file_exists(public_path($user->img_url))) {
                    unlink(public_path($user->img_url));
                }

                $user->img_url = $img_url; // Correct property to set img_url
            }

            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Profile updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }



    public function UserLogout(Request $request)
    {
        $request->user()->tokens()->delete();
        return redirect('/nexus-login-page');
    }

    // --- USER ROLE & PERMISSION MANAGEMENT APIs ---

    public function GetAllUsers()
    {
        try {
            $users = User::select('id', 'name', 'email', 'mobile', 'role', 'status', 'permissions', 'img_url', 'created_at')
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($user) {
                    $perms = $user->permissions ? json_decode($user->permissions, true) : null;
                    return [
                        'id'          => $user->id,
                        'name'        => $user->name ?? 'N/A',
                        'email'       => $user->email ?? 'N/A',
                        'mobile'      => $user->mobile ?? 'N/A',
                        'role'        => $user->role ?? 'users',
                        'status'      => $user->status ?? 'approved',
                        'permissions' => $perms,
                        'img_url'     => $user->img_url ? asset($user->img_url) : asset('backend/assets/img/profile-img.png'),
                        'date'        => \Carbon\Carbon::parse($user->created_at)->format('d M Y'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data'   => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function CreateUserByAdmin(Request $request)
    {
        try {
            $email = trim($request->input('email', ''));
            if ($email === '') {
                $email = null;
            }

            if ($email) {
                $request->validate([
                    'email' => 'email|max:50|unique:users,email',
                ]);
            }

            $request->validate([
                'name'     => 'required|string|max:50',
                'mobile'   => 'required|string|max:20',
                'password' => 'required|string|min:4',
                'role'     => 'required|string',
                'status'   => 'required|string',
            ]);

            $img_url = null;
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$t}-{$file_name}";
                $img_url = "uploads/user-img/{$img_name}";
                $img->move(public_path('uploads/user-img'), $img_name);
            }

            $permissionsJson = $request->input('permissions');
            if (is_array($permissionsJson)) {
                $permissionsJson = json_encode($permissionsJson);
            }

            $user = User::create([
                'name'        => $request->input('name'),
                'email'       => $email,
                'mobile'      => $request->input('mobile'),
                'password'    => Hash::make($request->input('password')),
                'role'        => $request->input('role', 'cashier'),
                'status'      => $request->input('status', 'approved'),
                'permissions' => $permissionsJson,
                'otp'         => '0',
                'img_url'     => $img_url,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'নতুন ইউজার সফলভাবে তৈরি করা হয়েছে।'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $errors = implode(', ', \Illuminate\Support\Arr::flatten($ve->errors()));
            return response()->json([
                'status'  => 'fail',
                'message' => 'তথ্য সঠিক নয়: ' . $errors
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdateUserRoleStatus(Request $request)
    {
        try {
            $request->validate([
                'id'     => 'required|exists:users,id',
                'role'   => 'required|string',
                'status' => 'required|string',
            ]);

            $user = User::findOrFail($request->input('id'));

            if ($request->filled('name')) {
                $user->name = $request->input('name');
            }
            if ($request->filled('mobile')) {
                $user->mobile = $request->input('mobile');
            }
            if ($request->has('email')) {
                $email = trim($request->input('email', ''));
                $user->email = ($email === '') ? null : $email;
            }

            $user->role = $request->input('role');
            $user->status = $request->input('status');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->has('permissions')) {
                $perms = $request->input('permissions');
                if (is_array($perms)) {
                    $perms = json_encode($perms);
                }
                $user->permissions = $perms;
            }

            $user->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'ইউজার রোল ও পারমিশন সফলভাবে আপডেট হয়েছে।'
            ]);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            $errors = implode(', ', \Illuminate\Support\Arr::flatten($ve->errors()));
            return response()->json([
                'status'  => 'fail',
                'message' => 'তথ্য সঠিক নয়: ' . $errors
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function DeleteUserByAdmin(Request $request)
    {
        try {
            $id = $request->input('id');
            $authUser = Auth::user();

            if ($authUser && $authUser->id == $id) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'নিজের একাউন্ট ডিলিট করা সম্ভব নয়!'
                ], 400);
            }

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'ইউজার ডিলিট করা হয়েছে।'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
