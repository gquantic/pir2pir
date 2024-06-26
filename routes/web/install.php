<?php

use App\Http\Controllers\Web\Install\InstallController;
use App\Http\Controllers\Web\Install\UpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['no.http.cache'])
	->group(function () {
		// upgrade
		Route::prefix('upgrade')
			->controller(UpdateController::class)
			->group(function () {
				Route::get('/', 'index');
				Route::post('run', 'run');
			});
		
		// install
		Route::middleware(['install'])
			->prefix('install')
			->controller(InstallController::class)
			->group(function () {
				Route::get('/', 'starting');
				Route::get('site_info', 'siteInfo');
				Route::post('site_info', 'siteInfo');
				Route::get('system_compatibility', 'systemCompatibility');
				Route::get('database', 'database');
				Route::post('database', 'database');
				Route::get('database_import', 'databaseImport');
				Route::get('cron_jobs', 'cronJobs');
				Route::get('finish', 'finish');
			});
	});
