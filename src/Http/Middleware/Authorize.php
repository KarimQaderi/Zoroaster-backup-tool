<?php

namespace KarimQaderi\ZoroasterBackupTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use KarimQaderi\ZoroasterBackupTool\BackupTool;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(BackupTool::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
