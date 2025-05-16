<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput($request->except('password'));
            }

            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'viewer', // Set default role
            ]);

            DB::commit();

            // Log the user in after registration
            auth()->login($user);

            return redirect()
                ->route('products.index')
                ->with('success', 'Account created and logged in successfully!');

        } catch (QueryException $e) {
            DB::rollBack();
            
            if ($e->getCode() == 23000) { // Duplicate entry error
                return redirect()
                    ->back()
                    ->withErrors(['email' => 'This email address is already registered.'])
                    ->withInput($request->except('password'));
            }

            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred during registration. Please try again.'])
                ->withInput($request->except('password'));
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withErrors(['error' => 'An unexpected error occurred. Please try again.'])
                ->withInput($request->except('password'));
        }
    }
}
