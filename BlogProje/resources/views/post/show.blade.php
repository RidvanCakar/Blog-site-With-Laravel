<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
        }

        .post-content {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #555;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #444;
        }

        .comment-list {
            list-style-type: none;
            padding-left: 0;
        }

        .comment-item {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .comment-author {
            font-weight: bold;
            color: #007bff;
        }

        .comment-meta {
            font-size: 0.9rem;
            color: #777;
        }

        .comment-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            font-size: 1rem;
            resize: vertical;
        }

        .comment-form button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .comment-form button:hover {
            background-color: #0056b3;
        }

        .message-success, .message-error {
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .message-success {
            background-color: #d4edda;
            color: #155724;
        }

        .message-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-link, .edit-button, .delete-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
            color: white;
        }

        .back-link {
            background-color: #6c757d;
        }

        .back-link:hover {
            background-color: #5a6268;
        }

        .edit-button {
            background-color: #28a745;
            margin-right: 10px;
        }

        .edit-button:hover {
            background-color: #218838;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="post-title">{{ $post->title }}</h1>
        <p class="post-content">{{ $post->content }}</p>

        {{-- Eğer giriş yapan adminse, düzenle ve sil butonları göster --}}
        @auth
            @if (Auth::user()->role === 'admin')
                <a href="/post/edit/{{ $post->id }}" class="edit-button">Düzenle</a>
                <form action="/post/delete/{{ $post->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button" onclick="return confirm('Makale silinsin mi?')">Sil</button>
                </form>
            @endif
        @endauth

        <h2>Yorumlar</h2>
        <ul class="comment-list">
            @foreach ($post->comments as $comment)
                <li class="comment-item">
                    <span class="comment-author">{{ $comment->user->name ?? 'Bilinmeyen Kullanıcı' }}:</span>
                    <p>{{ $comment->content }}</p>
                    <small class="comment-meta">Yorum Yapılma Tarihi: {{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y H:i') }}</small>

                    {{-- Eğer adminse, yorumları silme butonu --}}
        @auth
            @if (Auth::user()->role === 'admin')
                <form action="{{ route('comment.delete', $comment->id) }}" method="POST" style="display:inline;">
                    @csrf
                     @method('DELETE')
                     <button type="submit" class="delete-button" onclick="return confirm('Yorum silinsin mi?')">Sil</button>
                </form>
            @endif
        @endauth
                </li>
            @endforeach
        </ul>

        {{-- Yorum yapma alanı --}}
        @auth
            <h3>Yorum Ekle</h3>
            <form action="/post/{{ $post->id }}/comment" method="POST" class="comment-form">
                @csrf
                <textarea name="content" required placeholder="Yorumunuzu buraya yazın..."></textarea>
                <button type="submit">Yorumu Gönder</button>
            </form>
        @else
            <p>Yorum yapabilmek için <a href="{{ route('login') }}">giriş yap</a>.</p>
        @endauth

        <a href="/posts" class="back-link">Geri Dön</a>

        @if (session('success'))
            <div class="message-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="message-error">{{ session('error') }}</div>
        @endif
    </div>
</body>
</html>
