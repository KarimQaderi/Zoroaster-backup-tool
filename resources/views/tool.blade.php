@extends('Zoroaster::layout')

@section('content')


    <div class="card-tool uk-padding-small uk-margin-large-bottom create_backup_target" hidden>
        <h1 class="resourceName">ایجاد پشتیبان گیری</h1>
        <label>فضای مورد نظر خورد را انتخاب کنید</label>
        <select style="width:150px;margin: 10px;" class="uk-select create_backup_disk">
            @foreach ($backups as $backup)
                @if ($loop->first)
                    @php($disk=$backup['disk'])
                @endif
                <option value="{{ $backup['disk'] }}">{{ $backup['disk'] }}</option>
            @endforeach
        </select>
        <button class="btn uk-button uk-button-primary uk-border-rounded create_backup">ایجاد پشتیبان گیری</button>
       <b><div class="create_backup_massage"></div></b>
    </div>


    <div class="uk-child-width-1-2 resourceName_2" uk-grid>
        <div>
            <h1 class="resourceName">پشتیبان گیری</h1>
        </div>
        <div class="uk-text-left">
            <a class="btn uk-button uk-button-primary uk-border-rounded" uk-toggle="target:.create_backup_target">ایجاد پشتیبان گیری</a>
        </div>
    </div>

    <div class="card-tool">
        <table class="uk-table dataTables uk-table-middle">
            <thead>
            <tr>
                <th class="uk-text-center">Disk</th>
                <th class="uk-text-center">سالم</th>
                <th class="uk-text-center">تعداد</th>
                <th class="uk-text-center">جدیدترین</th>
                <th class="uk-text-center">فضای مصرف شده</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($backups as $backup)
                <tr>
                    <td class="uk-text-center">{{ $backup['disk'] }}</td>
                    <td class="uk-text-center">{{ ($backup['healthy'])? 'OK' : 'NO' }}</td>
                    <td class="uk-text-center">{{ $backup['amount'] }}</td>
                    <td class="uk-text-center">{{ $backup['newest'] }}</td>
                    <td class="uk-text-center">{{ $backup['usedStorage'] }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>


    </div>

    <br>
    <br>

    @php($disk=null)
    <div class="card-tool">
        <select style="width:150px;margin: 10px;" class="uk-select backup_lists_select">
            @foreach ($backups as $backup)
                @if ($loop->first)
                    @php($disk=$backup['disk'])
                @endif
                <option value="{{ $backup['disk'] }}">{{ $backup['disk'] }}</option>
            @endforeach
        </select>
        <table class="uk-table dataTables uk-table-middle backup_lists">
            <thead>
            <tr>
                <th>مسیر</th>
                <th>تاریخ ساخت</th>
                <th>حجم</th>
                <th  class="uk-text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>


            </tbody>
        </table>


    </div>

    <script>

        get_backup_lists('{{ $disk }}');


        click('[uk-icon="delete"]', function ($this) {
            var url = $($this).attr('data-href');
            var date = $($this).attr('date');
            Confirm_delete('حذف ' + date, function () {
                window.location.href = url;
            })
        })

        click('.create_backup', function ($this) {
            var create_backup_massage = $('.create_backup_massage');
            create_backup_massage.html('درحال پشتیبان گیری');
            var disk = $('.create_backup_disk').find(':selected').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('ZoroasterBackupTool.create') }}',
                data: {
                    disk: disk
                },
                success: function (data) {
                    create_backup_massage.html(data.massage);
                    get_backup_lists(disk);
                    notification(data.massage, 'success');
                }
            })
        });


        change('.backup_lists_select', function ($this) {
            get_backup_lists($($this).find(':selected').val());
        });

        function get_backup_lists(disk) {
            $.ajax({
                type: 'GET',
                url: '{{ route('ZoroasterBackupTool.list') }}',
                data: {
                    disk: disk
                },
                success: function (data) {
                    $('.backup_lists tbody').html(data);
                }
            })
        }
    </script>

@endsection