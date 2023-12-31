@php
//    $faviconUrl = getSettings('favicon')->getFaviconUrl();
    $faviconUrl =  '/uploads/favicon/wrwe.jpg';
@endphp
<link rel="shortcut icon" href="{{$faviconUrl ? asset($faviconUrl) :  asset('/img/VIC-LOGO_12.png')}}">
<link rel="apple-touch-icon" href="{{$faviconUrl ? asset($faviconUrl) :  asset('/img/VIC-LOGO_12.png')}}">
<link rel="shortcut icon" href="https://viconsortium.com/public/uploads/VIC-LOGO_12.png">
