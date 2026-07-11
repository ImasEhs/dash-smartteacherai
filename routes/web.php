<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/' , [LoginController::class , 'index'])->name('login');
Route::get('/dashboard' , [DashboardController::class , 'index'])->name('dashboard');
Route::get('/carrier' , [DashboardController::class , 'carrier'])->name('carrier');
Route::post('/carrier/target_karir' , [DashboardController::class , 'update_target_karir'])->name('update_target_karir');
Route::post('/carrier/target_mingguan' , [DashboardController::class , 'update_target_mingguan'])->name('update_target_mingguan');
Route::get('/content' , [DashboardController::class , 'content'])->name('content');
Route::get('/certificate' , [DashboardController::class , 'certificate'])->name('certificate');
Route::get('/ask_ai' , [DashboardController::class , 'ask_ai'])->name('ask_ai');
Route::get('/chat_ai' , [DashboardController::class , 'chat_ai'])->name('chat_ai');
Route::get('/history_chat_ai' , [DashboardController::class , 'history_chat_ai'])->name('history_chat_ai');
Route::post('/submit_chat_ai' , [DashboardController::class , 'submit_chat_ai'])->name('submit_chat_ai');
Route::get('/image_evaluate' , [DashboardController::class , 'image_evaluate'])->name('image_evaluate');
Route::post('/submit_evaluate_image', [DashboardController::class , 'submit_evaluate_image'])->name('submit_evaluate_image');
Route::get('/teaching_module' , [DashboardController::class , 'teaching_module'])->name('teaching_module');
Route::post('/submit_teaching_module' , [DashboardController::class , 'submit_teaching_module'])->name('submit_teaching_module');
Route::get('/make_exam' , [DashboardController::class , 'make_exam'])->name('make_exam');
Route::post('/submit_make_exam' , [DashboardController::class , 'submit_make_exam'])->name('submit_make_exam');
Route::post('/download_pdf_exam' , [DashboardController::class , 'download_pdf_exam'])->name('download_pdf_exam');
Route::post('/download_docx_exam' , [DashboardController::class , 'download_docx_exam'])->name('download_docx_exam');
Route::get('/chat_with_docs' , [DashboardController::class , 'chat_with_docs'])->name('chat_with_docs');
Route::post('/submit_chat_with_docs' , [DashboardController::class , 'submit_chat_with_docs'])->name('submit_chat_with_docs');
Route::post('/submit_pretest/{id}' , [DashboardController::class , 'submit_pretest'])->name('submit_pretest');
Route::post('/submit_posttest/{id}' , [DashboardController::class , 'submit_posttest'])->name('submit_posttest');
Route::post('/submit_feedback' , [DashboardController::class , 'submit_feedback'])->name('submit_feedback');
Route::post('/upload_pelatihan' , [DashboardController::class , 'upload_pelatihan'])->name('upload_pelatihan');
Route::get('/materi_presentasi' , [DashboardController::class , 'materi_presentasi'])->name('materi_presentasi');
Route::post('/save-course', [DashboardController::class, 'toggle_save_course'])->name('toggle_save_course');
Route::post('/submit_materi_presentasi' , [DashboardController::class , 'submit_materi_presentasi'])->name('submit_materi_presentasi');
Route::get('/profil' , [DashboardController::class , 'profil'])->name('profil');
Route::post('/profil' , [DashboardController::class , 'submit_profil'])->name('submit_profil');

Route::get('/logout' , [LoginController::class , 'logout'])->name('logout');
Route::get('/bypass-login', [LoginController::class, 'bypass'])->name('bypass-login');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::get('/my_course/{id}' , [DashboardController::class , 'my_course'])->name('my_course');