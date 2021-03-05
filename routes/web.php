<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function (\Illuminate\Http\Request $request) {

    $request->session()->put('name', 'Lumen-Session');

    return response()->json([
        'message' => 'Setting session value to \'Lumen-Session\' for key \'session.name\'',
        'session.name' => $request->session()->get('name')
    ]);
});

$router->get('/session', function (\Illuminate\Http\Request $request) {

    return response()->json([
        'message' => 'Getting value from session with key \'session.name\'',
        'session.name' => $request->session()->get('name'),
    ]);
});
