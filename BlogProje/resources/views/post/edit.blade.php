@extends('layouts.navbar')

@section('content')
    <div class="container mx-auto p-8 rounded-lg shadow-lg bg-gradient-to-r from-purple-100 to-pink-100">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-8 text-center">Makale Düzenle</h1>

        <form action="/post/update/{{ $post->id }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <label for="title" class="block text-lg font-medium text-gray-800">Başlık:</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}" required
                       class="mt-2 p-4 w-full rounded-md border-2 border-purple-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-300 ease-in-out">
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <label for="content" class="block text-lg font-medium text-gray-800">İçerik:</label>
                <textarea name="content" id="content" required rows="8"
                          class="mt-2 p-4 w-full rounded-md border-2 border-purple-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-300 ease-in-out">{{ $post->content }}</textarea>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                        class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-full shadow-md hover:from-pink-500 hover:to-yellow-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
@endsection
