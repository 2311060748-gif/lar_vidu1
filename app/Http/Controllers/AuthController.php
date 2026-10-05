<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendVerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended(route(Auth::user()->role . '.dashboard'));
        }
        return view('auth.login');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->intended(route(Auth::user()->role . '.dashboard'));
        }
        return view('auth.register');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Nếu tài khoản chưa xác thực email, yêu cầu nhập mã OTP
            if (!$user->hasVerifiedEmail()) {
                if (!$user->verification_code || ($user->verification_code_expires_at && Carbon::now()->isAfter($user->verification_code_expires_at))) {
                    $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                    $user->update([
                        'verification_code' => $code,
                        'verification_code_expires_at' => Carbon::now()->addMinutes(15),
                    ]);
                    try {
                        Mail::to($user->email)->send(new SendVerificationCodeMail($user, $code));
                    } catch (\Exception $e) {
                        // Bỏ qua lỗi gửi mail để không chặn luồng đăng nhập
                    }
                }
                return redirect()->route('verification.notice')->with('info', 'Vui lòng nhập mã xác minh gồm 6 số đã được gửi đến Gmail.');
            }

            return redirect()->intended(route($user->role . '.dashboard'))->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'verification_code' => $code,
            'verification_code_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        Auth::login($user);

        try {
            Mail::to($user->email)->send(new SendVerificationCodeMail($user, $code));
            return redirect()->route('verification.notice')->with('success', 'Đăng ký thành công! Mã xác minh 6 số đã được gửi tới Gmail của bạn.');
        } catch (\Exception $e) {
            return redirect()->route('verification.notice')->with('error', 'Không thể gửi email: ' . $e->getMessage());
        }
    }

    /**
     * Show verify code form
     */
    public function showVerifyCode()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route(Auth::user()->role . '.dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle verify code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'Vui lòng nhập mã xác minh.',
            'code.digits' => 'Mã xác minh phải gồm đúng 6 chữ số.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->verification_code || $user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Mã xác minh không chính xác. Vui lòng kiểm tra lại.'])->withInput();
        }

        if ($user->verification_code_expires_at && Carbon::now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'Mã xác minh đã hết hạn. Vui lòng bấm gửi lại mã mới.'])->withInput();
        }

        $user->markEmailAsVerified();
        $user->update([
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        return redirect()->route($user->role . '.dashboard')->with('success', 'Xác minh tài khoản thành công!');
    }

    /**
     * Handle resend verify code
     */
    public function resendCode(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route($user->role . '.dashboard');
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'verification_code' => $code,
            'verification_code_expires_at' => Carbon::now()->addMinutes(15),
        ]);

        try {
            Mail::to($user->email)->send(new SendVerificationCodeMail($user, $code));
            return back()->with('success', 'Mã xác minh mới đã được gửi tới Gmail của bạn.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi gửi email: ' . $e->getMessage());
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất thành công!');
    }
}

