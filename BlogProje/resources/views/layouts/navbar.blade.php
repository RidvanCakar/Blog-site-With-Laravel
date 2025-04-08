<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Blog Sitesi</title>
    <style>
        nav {
            background-color: #333;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/posts">Ana Sayfa</a>
    
        @auth
            @if (Auth::user()->role === 'admin')
                <a href="/post/create">Makale Yaz</a>
            @endif
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:white;cursor:pointer;font-size:18px;">Çıkış Yap</button>
            </form>
        @else
            <a href="/login">Giriş Yap</a>
            <a href="/register">Kayıt Ol</a>
        @endauth
    </nav>
    

    <div style="padding: 20px;">
        @yield('content')
    </div>
</body>
</html>