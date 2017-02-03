<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Example</title>
</head>
<body>

<header>
    <div class="wrap">
        <p class="logined"> <span>Xin chào:</span> <strong>{{session()->get('frontend_login')['username']}}</strong> |
            <a href="#" id="logout"><a href="{{url('logout')}}">Thoát</a></a>
        </p>
    </div>
</header>        <!-- Content -->
<div class="container">
    After Frontend Login
</div>

</body>
</html>