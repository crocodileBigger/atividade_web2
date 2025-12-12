<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\Book;

Route::middleware('auth')->get('/debug-auth', function () {
    $user = auth()->user();
    $book = Book::first();
    
    $output = [
        'user_info' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => $user->user_type,
        ],
        'user_checks' => [
            'isAdmin()' => $user->isAdmin(),
            'isBibliotecario()' => $user->isBibliotecario(),
            'isCliente()' => $user->isCliente(),
        ],
        'gate_checks' => [],
    ];
    
    if ($book) {
        // Testar cada ability
        $abilities = ['viewAny', 'view', 'create', 'update', 'delete'];
        
        foreach ($abilities as $ability) {
            if ($ability === 'viewAny' || $ability === 'create') {
                $response = Gate::inspect($ability, Book::class);
            } else {
                $response = Gate::inspect($ability, $book);
            }
            
            $output['gate_checks'][$ability] = [
                'allowed' => $response->allowed(),
                'denied' => $response->denied(),
                'message' => $response->message(),
            ];
        }
    }
    
    return response()->json($output, 200, [], JSON_PRETTY_PRINT);
});
