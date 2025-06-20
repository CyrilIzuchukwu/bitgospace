<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    //

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('user.profile.index', compact('user', 'profile'));
    }


    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'country' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
            ]);

            DB::beginTransaction();

            $user->update(['name' => $validatedData['name']]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only(['country', 'state', 'city', 'address'])
            );

            DB::commit();

            return back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }


    public function updatePhone(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string|max:20',
            ]);

            Auth::user()->profile()->updateOrCreate(
                ['user_id' => Auth::id()],
                ['phone' => $request->phone]
            );

            return response()->json([
                'message' => 'Phone number updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function updateProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:3048',
            ]);

            $user = Auth::user();

            // ✅ Remove previous image if it exists
            if ($user->profile && $user->profile->profile_picture) {
                Storage::disk('public')->delete('profile_pictures/' . $user->profile->profile_picture);
            }

            // ✅ Store new profile picture to 'public/profile_pictures'
            $file = $request->file('profile_picture');
            $storedPath = $file->store('profile_pictures', 'public');

            // ✅ Save filename in DB (not full path, to keep it clean)
            $filename = basename($storedPath);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['profile_picture' => $filename]
            );

            return back()->with('success', 'Profile picture updated!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = implode(' ', array_map(fn($errors) => implode(' ', $errors), $e->errors()));
            return redirect()->back()->with('error', $errorMessages);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'message' => 'Current password is incorrect.'
                ], 422);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'message' => 'Password updated successfully.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }



    // public function updatePin(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $validated = $request->validate([
    //             'current_pin' => 'required|digits:4|numeric',
    //             'pin' => 'required|digits:4|numeric|different:current_pin|confirmed',
    //         ]);

    //         $user = Auth::user();
    //         $wallet = $user->wallet;

    //         // Check if wallet exists and has PIN set
    //         if (!$wallet || !$wallet->pin_set) {
    //             return back()->withInput()->with('error', 'Withdrawal PIN is not set yet.');
    //         }

    //         // Verify current PIN
    //         if (!Hash::check($validated['current_pin'], $wallet->pin)) {
    //             return back()->withInput()->with('error', 'Current PIN is incorrect.');
    //         }

    //         // Update the PIN
    //         $wallet->pin = Hash::make($validated['pin']);
    //         $wallet->save();

    //         DB::commit();

    //         // dd('successful');
    //         return redirect()->route('user.withdrawal')->with('success', 'Withdrawal PIN updated successfully');
    //     } catch (ValidationException $e) {
    //         DB::rollBack();
    //         // return back()->withErrors($e->validator)->withInput();
    //         return redirect()->back()->withErrors($e->validator)->withInput()->with('show_update_pin_modal', true);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withInput()->with('error', 'An error occurred while updating your PIN. Please try again.');
    //     }
    // }

    public function updatePin(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_pin' => 'required|digits:4|numeric',
                'pin' => 'required|digits:4|numeric|different:current_pin|confirmed',
            ]);

            $user = Auth::user();
            $wallet = $user->wallet;

            // Check if wallet exists and has PIN set
            if (!$wallet || !$wallet->pin_set) {
                return back()->withInput()->with('error', 'Withdrawal PIN is not set yet.');
            }

            // Verify current PIN BEFORE starting transaction
            if (!Hash::check($validated['current_pin'], $wallet->pin)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Current PIN is incorrect.')
                    ->with('show_update_pin_modal', true);
            }

            // Start transaction only after current PIN is verified
            DB::beginTransaction();

            try {
                // Update the PIN
                $wallet->pin = Hash::make($validated['pin']);
                $wallet->save();

                DB::commit();

                return redirect()->route('user.withdrawal')->with('success', 'Withdrawal PIN updated successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error', 'An error occurred while updating your PIN. Please try again.');
            }
        } catch (ValidationException $e) {
            // Handle validation errors (this happens before DB operations)
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('show_update_pin_modal', true);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            return back()->withInput()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
