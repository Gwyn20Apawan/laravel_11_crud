<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FileAuthController extends Controller
{
    /**
     * Show the file authentication form
     */
    public function showFileAuthForm()
    {
        return view('auth.file-auth');
    }

    /**
     * Handle file-based authentication
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auth_file' => 'required|file|mimes:txt,pdf|max:1024', // Max 1MB
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('auth_file');
            $content = file_get_contents($file->getRealPath());
            
            // Here you would implement your file-based authentication logic
            // This is just an example - you should implement proper security measures
            $credentials = json_decode($content, true);
            
            if (!$credentials || !isset($credentials['email']) || !isset($credentials['password'])) {
                return redirect()
                    ->back()
                    ->withErrors(['auth_file' => 'Invalid authentication file format.'])
                    ->withInput();
            }

            if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                $request->session()->regenerate();
                
                return redirect()
                    ->intended(route('products.index'))
                    ->with('success', 'File authentication successful!');
            }

            return redirect()
                ->back()
                ->withErrors(['auth_file' => 'Invalid credentials in authentication file.'])
                ->withInput();

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['auth_file' => 'Error processing authentication file.'])
                ->withInput();
        }
    }

    /**
     * Generate an authentication file for a user
     */
    public function generateAuthFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return redirect()
                    ->back()
                    ->withErrors(['email' => 'User not found.'])
                    ->withInput();
            }

            // Create authentication file content
            $authData = [
                'email' => $user->email,
                'password' => $request->password,
                'generated_at' => now()->toIso8601String(),
            ];

            // Generate file name
            $fileName = 'auth_' . $user->id . '_' . time() . '.txt';
            
            // Store the file
            Storage::put('auth_files/' . $fileName, json_encode($authData, JSON_PRETTY_PRINT));

            return response()->download(
                Storage::path('auth_files/' . $fileName),
                $fileName,
                ['Content-Type' => 'text/plain']
            )->deleteFileAfterSend();

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Error generating authentication file.'])
                ->withInput();
        }
    }
} 