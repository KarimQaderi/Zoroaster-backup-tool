<?php

namespace KarimQaderi\ZoroasterBackupTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use KarimQaderi\Zoroaster\Sidebar\FieldMenu\MenuItem;
use KarimQaderi\Zoroaster\Zoroaster;

class BackupToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ZoroasterBackupTool');

        Zoroaster::SidebarMenus([
            MenuItem::make()->route('ZoroasterBackupTool.index','پشتیبان گیری')->icon('archive')
        ]);

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['web', 'can:Zoroaster','can:Zoroaster-backup-tool'])
            ->namespace('KarimQaderi\ZoroasterBackupTool\Http\Controllers')
            ->prefix(config('Zoroaster.path').'/backup-tool')
            ->as('ZoroasterBackupTool.')
            ->group(__DIR__.'/../routes/web.php');
    }
}
