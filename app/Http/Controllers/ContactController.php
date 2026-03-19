<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $path = storage_path('app/contact_messages.json');
        $messages = [];

        if (File::exists($path)) {
            $decoded = json_decode(File::get($path), true);
            if (is_array($decoded)) {
                $messages = $decoded;
            }
        }

        array_unshift($messages, [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'created_at' => now()->toDateTimeString(),
        ]);

        File::put($path, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->to(route('vitrine') . '#contact')
            ->with('contact_success', 'Message envoye avec succes.');
    }
}
