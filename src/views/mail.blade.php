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
            font-family: 'Lato';
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

        .title {
            font-size: 96px;
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
        <table border="1" border-collapse="solid" style="width:100%">
            <th>Name</th>
            <th>Version</th>
            <th>Advisor</th>

            @foreach ($vul as $d)
                <tr style='
                @if ($d['version'] != '')
                    color: red;font-weight:bold;
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