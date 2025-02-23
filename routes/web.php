<?php

use App\Http\Controllers\TwilioController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::view('/', 'call');
// // Route::post('/call', 'VoiceController')->name('initiate_call');
// Route::post('/call', [App\Http\Controllers\VoiceController::class, 'initiateCall'])->name('initiate_call');


Route::get('/', [TwilioController::class, 'showCallForm']);
Route::post('/initiate-call', [TwilioController::class, 'initiateCall'])->name('initiate.call');
