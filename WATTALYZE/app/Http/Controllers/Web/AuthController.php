<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    // Exibir formulário de login
    public function showLoginForm()
    {
        return view('auth.Login');
    }

    // Processar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Verificar se o email foi verificado
            if (!Auth::user()->hasVerifiedEmail()) {
                // Enviar email de verificação automaticamente
                Auth::user()->sendEmailVerificationNotification();
                return redirect()->route('verification.notice');
            }

            return redirect()->intended('/home');
        }

        // Retornar erro específico para credenciais inválidas
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Log::info('🔴 LOGOUT CHAMADO');
        Log::info('User ID: ' . (Auth::id() ?? 'null'));

        if (!Auth::check()) {
            return redirect('/')->with('error', 'Você já está deslogado');
        }

        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('🟢 LOGOUT CONCLUÍDO');
            return redirect('/')->with('status', 'Você saiu com sucesso!');
        } catch (\Exception $e) {
            Log::error('❌ ERRO: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao sair');
        }
    }

    // Exibir formulário de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Processar registro
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'unique:users,email',
                    'max:255'
                ],
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])/' // Pelo menos uma letra e um número
                ],
            ], [
                'email.unique' => 'Este email já está cadastrado no sistema.',
                'password.regex' => 'A senha deve conter pelo menos uma letra e um número.',
                'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
                'password.confirmed' => 'As senhas não coincidem.',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Disparar evento de registro para enviar email de verificação
            event(new Registered($user));

            // NÃO fazer login automático, redirecionar para página de login
            return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Por favor, faça login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    // Exibir aviso de verificação de email
    public function showVerificationNotice()
    {
        // Se o usuário já verificou o email, redirecionar para home
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        return view('auth.verify-email');
    }

    // Processar verificação de email
    public function verifyEmail(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return response()->json([
                'error' => 'Usuário não encontrado'
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            // FAZER LOGIN AUTOMÁTICO DO USUÁRIO
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Email já foi verificado anteriormente.',
                'user' => $user->name
            ]);
        }

        // Verificar hash
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json([
                'error' => 'Link de verificação inválido'
            ], 400);
        }

        // Marcar como verificado
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // FAZER LOGIN AUTOMÁTICO DO USUÁRIO
            Auth::login($user);
        }

        return redirect()->route('dashboard.home')->with('success', 'Email verificado com sucesso! Bem-vindo ao sistema.');
    }

    // Reenviar email de verificação
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link de verificação reenviado com sucesso!');
    }

    // Exibir formulário "Esqueceu a senha"
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Enviar link de recuperação
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Link de recuperação enviado para seu email!'])
            : back()->withErrors(['email' => 'Não foi possível enviar o link de recuperação']);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Processar reset de senha
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])/' // Pelo menos uma letra e um número
            ],
        ], [
            'password.regex' => 'A senha deve conter pelo menos uma letra e um número.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Senha alterada com sucesso!')
            : back()->withErrors(['email' => 'Erro ao redefinir a senha.']);
    }

    // Atualizar perfil
    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])/'
            ],
        ], [
            'password.regex' => 'A senha deve conter pelo menos uma letra e um número.',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return back()->with('status', 'Dados atualizados com sucesso.');
    }
}
