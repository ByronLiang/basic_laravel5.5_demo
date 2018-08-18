<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ $title or '' }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css/normalize.min.css">
    <link rel="stylesheet" href="{{ mix('/static/css/web.css') }}">
</head>
<body>
<div id="app">@yield('main')</div>
<script src="{{ mix('/static/js/web.js') }}"></script>
@if ($errors->count() > 0)
    <script type="text/javascript">
        $ele.$message.error('{{ array_first($errors->all()) }}');
    </script>
@endif

@if (old('success_msg'))
    <script type="text/javascript">
        $ele.$message.success('{{ old('success_msg') }}');
    </script>
@endif
@if (old('error_msg'))
    <script type="text/javascript">
        $ele.$message.error('{{ old('error_msg') }}');
    </script>
@endif
</body>
</html>