<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>Bejou</title>

    <link rel="favicon" href="/images/icon.png">

    <link rel="manifest" href="/manifest.json">

    <link rel="apple-touch-icon" sizes="1024x1024" href="/images/icon.png">
    <link rel="stylesheet" href="/style.css?{{ uniqid() }}" />
</head>
<body>

<div class="navigation-wrapper">
    <nav class="navigation">
        <a href="/" class="logo">betterjournal</a>
        <a href="/calendar">Alles</a>
    </nav>
</div>

{{ $belowHeader ?? '' }}



<div class="content">
    {{ $slot }}


    @if(!strpos($_SERVER['REQUEST_URI'], 'edit') && !strpos($_SERVER['REQUEST_URI'], 'add'))
    <a href="/journal/add" class="floating">add</a>
    @endif
</div>

</body>
</html>
