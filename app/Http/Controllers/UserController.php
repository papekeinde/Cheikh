<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Schema::hasColumn('users', 'role')
                ? (User::where('role', 'superadmin')->first() ?? User::first())
                : User::first();

            if (!$user) {
                throw new \RuntimeException('No user found via DB');
            }

            $projets = Projet::where('user_id', $user->id)
                ->approved()
                ->orderBy('ordre')
                ->get();
        } catch (\Throwable $e) {
            // Fallback: use Supabase REST API when PostgreSQL pooler is unreachable
            [$user, $projets] = $this->fetchFromSupabaseRest();
        }

        return view('vitrine', compact('user', 'projets'));
    }

    /**
     * Fetch user and projects from Supabase REST API (PostgREST).
     */
    private function fetchFromSupabaseRest(): array
    {
        $url = config('services.supabase.url');
        $key = config('services.supabase.anon_key');

        if (!$url || !$key) {
            return [
                new User(['nom' => 'Cheikh Keinde', 'photo' => null]),
                collect(),
            ];
        }

        $headers = ['apikey' => $key, 'Authorization' => "Bearer {$key}"];

        try {
            $userData = Http::withHeaders($headers)
                ->get("{$url}/rest/v1/users", [
                    'select' => '*',
                    'role' => 'eq.superadmin',
                    'limit' => 1,
                ])->json();

            $user = !empty($userData[0])
                ? new User($userData[0])
                : new User(['nom' => 'Cheikh Keinde', 'photo' => null]);

            $userId = $userData[0]['id'] ?? null;

            $projetsData = Http::withHeaders($headers)
                ->get("{$url}/rest/v1/projets", [
                    'select' => '*',
                    'status' => 'eq.approved',
                    'order' => 'ordre.asc',
                ] + ($userId ? ['user_id' => "eq.{$userId}"] : []))
                ->json();

            $projets = collect($projetsData ?? [])->map(fn($p) => new Projet($p));
        } catch (\Throwable $e) {
            $user = new User(['nom' => 'Cheikh Keinde', 'photo' => null]);
            $projets = collect();
        }

        return [$user, $projets];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
