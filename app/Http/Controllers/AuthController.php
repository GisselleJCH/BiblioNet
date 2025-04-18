<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function index() {
        return view("modules/auth/login");
    }

    public function registro(){
        return view("modules/auth/registro");
    }

    public function registrar(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user' => 'required|string|min:5|max:20|unique:users,user',
            'password' => 'required|string|min:10|max:25',
        ]);

        // Si la validación es correcta, se crea el usuario
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->user = $request->user;
        $item->password = Hash::make($request->password);
        $item->save();
        return redirect()->route('login')->with('success', 'Registro exitoso');
    }

    public function logear(Request $request){
        $credenciales = [
            'user' => $request->user,
            'password' => $request->password
        ];

        if (Auth::attempt($credenciales)){
            return to_route('home');
        } else {
            return back()->withErrors(['login' => 'Usuario o contraseña incorrectos']);
        }
    }

    public function logout(){
        session()->flush();
        Auth::logout();
        return to_route('login');
    }

    // Mostrar el formulario de solicitud de restablecimiento de contraseña
    public function showLinkRequestForm() {
        return view('modules.auth.passwords.email');
    }

    // Enviar el enlace de restablecimiento de contraseña
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Mostrar el formulario de restablecimiento de contraseña
    public function showResetForm($token) {
        return view('modules.auth.passwords.reset', ['token' => $token]);
    }

    // Restablecer la contraseña
    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}