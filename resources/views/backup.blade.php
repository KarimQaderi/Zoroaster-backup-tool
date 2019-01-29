@foreach ($lists as $list)
    <tr>
        <td>{{ $list['path'] }}</td>
        <td>{{ $list['date'] }}</td>
        <td>{{ $list['size'] }}</td>

        <td class="action_btn" style="width: 134px;text-align: center">
            <a uk-icon="download-2" href="{{ route('ZoroasterBackupTool.download') }}?path={{ $list['path'] }}&disk={{ $disk }}"></a>
            <button uk-icon="delete"
                    date="{{ $list['date'] }}"
                    data-href="{{ route('ZoroasterBackupTool.delete') }}?path={{ $list['path'] }}&disk={{ $disk }}">
            </button>
        </td>
    </tr>
@endforeach
