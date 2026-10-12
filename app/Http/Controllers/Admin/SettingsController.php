<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::orderBy('key')->get()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'settings.contact_email' => ['nullable', 'email'],
            'settings.contact_phone' => ['nullable', 'string', 'max:30'],
        ]);

        foreach ($request->input('settings', []) as $key => $value) {
            Setting::set($key, $value);
        }

        Setting::flushCache();

        return back()->with('success', 'Paramètres enregistrés avec succès.');
    }
}
