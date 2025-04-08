@extends('layouts.navbar')

@section('content')
    <div class="container">
        <h1>Makale Listesi</h1>
        <ul class="post-list">
            @foreach ($posts as $post)
                <li class="post-item">
                    <strong>{{ $post->title }}</strong>
                    <p>{{ Str::limit($post->content, 100) }}</p>
                    <a href="/post/{{ $post->id }}">Detayı Gör</a>
                </li>
            @endforeach
        </ul>

        @auth
            @if (Auth::user()->role === 'admin') 
                <a href="/post/create" class="add-post-link">Yeni Makale Ekle</a> 
            @endif
        @endauth
    </div>
@endsection


@push('styles')
    <style>
        /* Genel Stil */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0; /* Hafif kenarlık */
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .user-info {
            font-size: 1rem;
            color: #777;
            margin-bottom: 20px;
        }

        .post-list {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .post-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e5e5; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .post-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .post-excerpt {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .view-detail-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px solid #007bff;
        }

        .view-detail-link:hover {
            text-decoration: none;
            color: #0056b3;
        }

        .post-actions {
            margin-top: 15px;
        }

        .edit-button, .delete-button {
            padding: 8px 15px;
            font-size: 1rem;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-button {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
        }

        .edit-button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .delete-button {
            background-color: #e3342f;
            color: #fff;
            border: 1px solid #e3342f;
        }

        .delete-button:hover {
            background-color: #cc1f1a;
            border-color: #cc1f1a;
        }

        .add-post-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1rem;
            text-align: center;
            border: 1px solid #28a745;
            transition: background-color 0.3s;
        }

        .add-post-button:hover {
            background-color: #218838;
            border-color: #218838;
        }

    </style>
@endpush

