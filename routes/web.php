<?php

    use Illuminate\Support\Facades\Route;

    Route::get('backups' , 'BackupsController@index')->name('list');
    Route::get('backups-create' , 'BackupsController@create')->name('create');
    Route::get('backups-delete' , 'BackupsController@delete')->name('delete');

    Route::get('download-backup' , 'DownloadBackupController')->name('download');

    Route::get('/' , 'BackupStatusesController@index')->name('index');
//    Route::post('clean-backups' , 'CleanBackupsController');
