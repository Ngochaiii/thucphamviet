<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Nếu đã đăng nhập thì redirect
        if (auth()->check()) {
            return auth()->user()->is_admin ? redirect('/admin') : redirect('/');
        }

        return view('src.admin.auth.login');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        // Nếu đã đăng nhập thì redirect
        if (auth()->check()) {
            return auth()->user()->is_admin ? redirect('/admin') : redirect('/');
        }

        return view('src.admin.auth.register');
    }

    /**
     * Đăng ký
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'in:0,1', // Validate role nếu có
        ], [
            'first_name.required' => 'Vui lòng nhập tên',
            'last_name.required' => 'Vui lòng nhập họ',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự',
        ]);

        $user = $this->authRepository->createUser($request->all());

        // Auto login sau khi đăng ký
        Auth::login($user);

        // Redirect dựa trên role
        if ($user->is_admin) {
            return redirect('/admin')->with('success', 'Đăng ký thành công! Chào mừng Admin!');
        }

        return redirect('/')->with('success', 'Đăng ký thành công! Chào mừng bạn đến với website!');
    }

    /**
     * Đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authRepository->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Tài khoản đã bị khóa.',
            ])->withInput();
        }

        // Đăng nhập user
        Auth::login($user, $request->filled('remember'));

        // Redirect dựa trên role
        if ($user->is_admin) {
            return redirect()->intended('/admin')->with('success', 'Chào mừng Admin!');
        }

        return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất!');
    }

    /**
     * Cập nhật profile - Chỉ cho user đã đăng nhập
     */
    public function updateProfile(Request $request)
    {
        // Check đăng nhập trong method
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để cập nhật profile');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = $this->authRepository->updateProfile(
            auth()->id(),
            $request->only(['first_name', 'last_name', 'phone'])
        );

        return back()->with('success', 'Cập nhật thành công!');
    }

    /**
     * Đổi mật khẩu - Chỉ cho user đã đăng nhập
     */
    public function changePassword(Request $request)
    {
        // Check đăng nhập trong method
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đổi mật khẩu');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không chính xác.',
            ]);
        }

        $this->authRepository->changePassword($user->id, $request->password);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
