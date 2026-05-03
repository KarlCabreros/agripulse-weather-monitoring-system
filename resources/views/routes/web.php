<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('farm-activities', 'pages.farm-activities')->name('farm-activities');
    Route::view('user-management', 'pages.user-management')->name('user-management');
    Route::view('audit-trail', 'pages.audit-trail')->name('audit-trail');
});

require __DIR__.'/settings.php';
