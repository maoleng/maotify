<!doctype html>
<html lang="en">
@include('theme.head_tag')
<body class="fixed-top-navbar top-nav">
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<div class="wrapper">
    @include('theme.header')
    @yield('content')
</div>
@include('theme.script_tag')
@yield('script')
</body>
</html>
