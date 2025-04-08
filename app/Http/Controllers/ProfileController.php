<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserAddress;
use App\Models\UserMeasurement;
use App\Models\UserPreference;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $defaultLayout = (in_array($request->user()->role, ['admin', 'seller'])) ? 'layouts.admin_seller.app' : 'layouts.end_user.app';
        $layout = in_array(Auth::user()->role, ['admin', 'seller'])
            ? 'layouts.admin_seller.app'
            : 'layouts.end_user.app';
        $user = $request->user();
        $measurement = $user->measurement;
        $calculatedSize = $measurement ? $this->calculatePreferredSize($measurement) : 'N/A';

        if (in_array($user->role, ['admin', 'seller'])) {
            return view('profile.editForAdmin', [
                'user' => $user,
                'layout' => $layout,
                'role' => $user->role,
                'calculatedSize' => $calculatedSize,
            ]);
        }

        return view('profile.editForEndUser', [
            'user' => $user,
            'layout' => $layout,
            'role' => $user->role,
            'calculatedSize' => $calculatedSize,
        ]);
    }

    public function storeAddress(Request $request)
    {
        $request->merge([
            'is_default' => $request->input('is_default') === 'on',
        ]);

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:12',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'state' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        if ($request->input('is_default')) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }
        UserAddress::create([
            'user_id' => Auth::id(),
            'recipient_name' => $request->recipient_name,
            'phone_number' => $request->phone_number,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'postal_code' => $request->postal_code,
            'state' => $request->state,
            'reference' => $request->reference,
            'is_default' => $request->is_default,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Address created successfully.');
    }

    public function updatePreference(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'color' => 'nullable|string',
            'chest' => 'nullable|numeric|min:30|max:150',
            'waist' => 'nullable|numeric|min:25|max:130',
            'hips' => 'nullable|numeric|min:30|max:150',
            'arm_length' => 'nullable|numeric|min:30|max:100',
            'foot_length' => 'nullable|numeric|min:20|max:35',
        ]);

        $preference = UserPreference::updateOrCreate(
            ['user_id' => $user->id],
            ['preference_color' => $request->input('color')]
        );

        $measurement = UserMeasurement::updateOrCreate(
            ['user_id' => $user->id],
            [
                'chest' => $request->input('chest'),
                'waist' => $request->input('waist'),
                'hips' => $request->input('hips'),
                'arm_length' => $request->input('arm_length'),
                'foot_length' => $request->input('foot_length'),
            ]
        );

        try {
            $preference->preference_size = $measurement->calculateSize();
            $preference->save();

            session()->put('preference_color', $preference->preference_color);
            session()->put('preference_size', $preference->preference_size);
        } catch (Exception $e) {
            return redirect()->route('profile.edit')->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('profile.edit')->with('status', 'Preferences and measurements updated.');
    }

    public function updateAddress(Request $request, $addressId)
    {
        $request->merge([
            'is_default' => $request->input('is_default') === 'on',
        ]);
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'state' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);

        $address = UserAddress::findOrFail($addressId);
        if ($request->input('is_default')) {
            UserAddress::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }
        $address->update([
            'recipient_name' => $request->recipient_name,
            'phone_number' => $request->phone_number,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'postal_code' => $request->postal_code,
            'state' => $request->state,
            'reference' => $request->reference,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('profile.edit');
    }

    public function deleteAddress(Request $request, $addressId)
    {
        $address = UserAddress::findOrFail($addressId);

        $address->delete();

        return redirect()->route('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function calculatePreferredSize($measurement)
    {
        if (! $measurement) {
            return 'N/A';
        }

        $chest = $measurement->chest;

        if ($chest < 90) {
            return 'S';
        } elseif ($chest < 100) {
            return 'M';
        } elseif ($chest < 110) {
            return 'L';
        } else {
            return 'XL';
        }
    }
}
