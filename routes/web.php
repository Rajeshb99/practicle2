<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WhatsAppController; // Assuming you have a WhatsAppController
  
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group that
| contains the "web" middleware group. Now create something great!
|
*/
  
Route::post('/send-whatsapp', [WhatsAppController::class, 'sendWhatsAppMessage'])->name('message.send');
Route::post('/receive-message', [WhatsAppController::class, 'receivedWhatsAppMessage']);
Route::get('/get-message', [WhatsAppController::class, 'getWhatsAppMessage']);
Route::get('/message-create', [WhatsAppController::class, 'create'])->name('message.create');
