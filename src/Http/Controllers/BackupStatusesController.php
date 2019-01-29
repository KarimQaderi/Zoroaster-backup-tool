<?php

    namespace KarimQaderi\ZoroasterBackupTool\Http\Controllers;

    use Spatie\Backup\Helpers\Format;
    use Illuminate\Support\Facades\Cache;
    use Spatie\Backup\Tasks\Monitor\BackupDestinationStatus;
    use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

    class BackupStatusesController extends ApiController
    {
        public function index()
        {
            return view('ZoroasterBackupTool::tool')->with([
                'backups' => Cache::remember('backup-statuses' , 1 / 15 , function(){
                    return BackupDestinationStatusFactory::createForMonitorConfig(config('backup.monitor_backups'))
                        ->map(function(BackupDestinationStatus $backupDestinationStatus){
                            return [
                                'name' => $backupDestinationStatus->backupDestination()->backupName() ,
                                'disk' => $backupDestinationStatus->backupDestination()->diskName() ,
                                'reachable' => $backupDestinationStatus->backupDestination()->isReachable() ,
                                'healthy' => $backupDestinationStatus->isHealthy() ,
                                'amount' => $backupDestinationStatus->backupDestination()->backups()->count() ,
                                'newest' => $backupDestinationStatus->backupDestination()->newestBackup()
                                    ? $backupDestinationStatus->backupDestination()->newestBackup()->date()->diffForHumans()
                                    : 'No backups present' ,
                                'usedStorage' => Format::humanReadableSize($backupDestinationStatus->backupDestination()->usedStorage()) ,
                            ];
                        })
                        ->values()
                        ->toArray();
                })

            ]);
        }
    }
