<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class CustomerAuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('store.auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('store.home'))
                ->with('success', 'Selamat datang kembali, ' . Auth::guard('customer')->user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('store.auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('store.home')
            ->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $customer->name . '!');
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah customer sudah ada berdasarkan google_id
            $customer = Customer::where('google_id', $googleUser->getId())->first();

            if ($customer) {
                // Login customer yang sudah ada
                Auth::guard('customer')->login($customer);
                return redirect()->route('store.home')
                    ->with('success', 'Selamat datang kembali, ' . $customer->name . '!');
            }

            // Cek apakah email sudah terdaftar
            $customer = Customer::where('email', $googleUser->getEmail())->first();

            if ($customer) {
                // Update google_id untuk customer yang sudah ada
                $customer->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
                Auth::guard('customer')->login($customer);
                return redirect()->route('store.home')
                    ->with('success', 'Selamat datang kembali, ' . $customer->name . '!');
            }

            // Buat customer baru
            $newCustomer = Customer::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(str()->random(16)), // Random password untuk akun Google
            ]);

            Auth::guard('customer')->login($newCustomer);

            return redirect()->route('store.home')
                ->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $newCustomer->name . '!');

        } catch (\Exception $e) {
            return redirect()->route('customer.login')
                ->withErrors(['google' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.']);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('store.home')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show profile
     */
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('store.profile', compact('customer'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $customer->update($request->only(['name', 'phone', 'address', 'city', 'postal_code']));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        /** @var Customer $customer */
        $customer = Auth::guard('customer')->user();

        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $customer->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
