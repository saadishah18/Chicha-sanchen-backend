<!DOCTYPE html>
<html>
<head>
    <title>Selected Advertisement Ads</title>
    <style type="text/css">
        table, th, td { border: 1px solid gray; padding: 5px; }
        @page {
            size: a4;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th style="text-align: left;">Ads <br/>ID</th>
        <th style="text-align: left;">Page</th>
        <th style="text-align: left;">Location</th>
        <th style="text-align: left;" >Redirect URL</th>
        <th style="text-align: left;" >Ads <br/> Image</th>
        <th style="text-align: left;" >US/VI</th>
        <th style="text-align: left;" >US/VI</th>
        <th style="text-align: left;" >Publish<br/> Date</th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th class="text-left">Display</th>
        <th class="text-left">Clicked</th>
        <th class="no-sort"></th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($selectedRows))
        @foreach($selectedRows as $res_data)
            <tr>
                <td style="text-align: left;">{{ $res_data['advertisement_id'] }}</td>
                <td style="text-align: left;">{{ !empty($res_data['page']) ? ucfirst($res_data['page']) : ' -' }}</td>
                <td style="text-align: left;">{{ !empty($res_data['location']) ? ucfirst($res_data['location']) : ' -' }}</td>
                <td style="max-width: 250px; text-align: left; white-space: pre-line; overflow-wrap: break-word;">
                    {!! $res_data['redirect_url'] !!}
                </td>
                <td>{!! $res_data['thumbnail'] !!}</td>
                <td style="text-align: left;">{{ $res_data['used_usvi'] }}</td>
                <td style="text-align: left;">{{ $res_data['clicked_usvi'] }}</td>
                <td>{{ !empty($res_data['created_at']) ? $res_data['created_at'] : '-' }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
</body>
</html>
