<?php

    namespace KarimQaderi\ZoroasterBackupTool\Http\Controllers;

    use Illuminate\Http\Request;
    use Spatie\Backup\Helpers\Format;
    use Illuminate\Support\Facades\Cache;
    use KarimQaderi\ZoroasterBackupTool\Rules\PathToZip;
    use KarimQaderi\ZoroasterBackupTool\Rules\BackupDisk;
    use Spatie\Backup\BackupDestination\Backup;
    use KarimQaderi\ZoroasterBackupTool\Jobs\CreateBackupJob;
    use Spatie\Backup\BackupDestination\BackupDestination;

    class BackupsController extends ApiController
    {
        public function index(Request $request)
        {
            $validated = $request->validate([
                'disk' => ['required' , new BackupDisk()] ,
            ]);

            $backupDestination = BackupDestination::create($validated['disk'] , config('backup.backup.name'));

            return view('ZoroasterBackupTool::backup')->with([
                'disk' => $request->disk ,
                'lists' => Cache::remember("backups-{$validated['disk']}" , 1 / 15 , function() use ($backupDestination){
                    return $backupDestination
                        ->backups()
                        ->map(function(Backup $backup){
                            return [
                                'path' => $backup->path() ,
                                'date' => $backup->date()->format('Y-m-d H:i:s') ,
                                'size' => Format::humanReadableSize($backup->size()) ,
                            ];
                        })
                        ->toArray();
                })]);
        }

        public function create()
        {
            dispatch(new CreateBackupJob());

            return response()->json([
                'massage' => 'پشتیبان گیری انجام شد'
            ]);
        }

        public function delete(Request $request)
        {
            $validated = $request->validate([
                'disk' => new BackupDisk() ,
                'path' => ['required' , new PathToZip()] ,
            ]);

            $backupDestination = BackupDestination::create($validated['disk'] , config('backup.backup.name'));

            $backupDestination = $backupDestination
                ->backups()
                ->first(function(Backup $backup) use ($validated){
                    return $backup->path() === $validated['path'];
                });
            if(!empty($backupDestination))
                $backupDestination->delete();
            else
                return redirect(route('ZoroasterBackupTool.index'))->with([
                    'error' => 'مشکلی پیش امد'
                ]);

            $this->respondSuccess();

            return redirect(route('ZoroasterBackupTool.index'))->with([
                'success' => 'با موفقیت حذف شد'
            ]);
        }
    }
