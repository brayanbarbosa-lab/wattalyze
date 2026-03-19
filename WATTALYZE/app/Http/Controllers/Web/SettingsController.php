<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\EnergyTariff;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    // Mostrar perfil com dados e formulário de troca de senha
    public function profile()
    {
        Artisan::call('alerts:check');
        $user = auth()->user();
        return view('settings.profile', compact('user'));
    }
    public function notifications()
    {
        $user = auth()->user();
        $alert = Alert::where('user_id', auth()->id())
            ->where('is_resolved', false)
            ->with(['device', 'environment'])
            ->latest()
            ->paginate(10);
        return view('alerts.active', [
            'user'  => $user,
            'alert' => $alert
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update($request->only(['name', 'email']));

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function security()
    {
        $user = auth()->user();
        return view('settings.security', compact('user'));
    }

    // Atualizar senha
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Senha atualizada com sucesso!');
    }
}
