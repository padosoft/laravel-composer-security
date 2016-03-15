<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato','monospace';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        table {
            border-collapse: collapse;
            padding: 5px;
        }

        table, td, th {
            border: 1px solid black;
            padding: 5px;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <table border="1"  style="width:100%">
            <th>Name</th>
            <th>Version</th>
            <th>Advisor</th>

            @foreach ($vul as $d)
                <tr style='
                @if ($d['version'] != '' && $d['isOk']==false)
                        color: red;font-weight:bold;
                @elseif ($d['version'] != '' && $d['isOk']==true)
                        color: darkorange;font-weight:bold;
                @endif
                        '>
                    <td>{{ $d['name'] }}</td>
                    <td>{{ $d['version'] }}</td>
                    <td>{{ $d['advisories'] }}</td>
                </tr>
            @endforeach

        </table>
    </div>
</div>
</body>
</html>
