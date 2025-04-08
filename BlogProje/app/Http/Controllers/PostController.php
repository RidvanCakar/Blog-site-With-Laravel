<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        Log::channel('db')->info('Yeni makale oluşturuldu: ' . $post->title . ' | Kullanıcı: ' . Auth::user()->email);

        return redirect('/posts')->with('success', 'Makale başarıyla kaydedildi!');
    }

    public function index()
    {
        $posts = Post::with('user')->get();
        return view('post.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('comments.user')->findOrFail($id);
        return view('post.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $id)
{
    $post = Post::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);

    $oldData = $post->only(['title', 'content']);
    $post->update([
        'title' => $request->title,
        'content' => $request->content,
    ]);
    $newData = $post->only(['title', 'content']);

    $changes = [];
    foreach ($oldData as $key => $value) {
        if ($value !== $newData[$key]) {
            $changes[$key] = [
                'eski makale:' => $value,
                'yeni makale:' => $newData[$key]
            ];
        }
    }

    Log::channel('db')->info("Makale güncellendi: ID={$post->id} | Kullanıcı: " . Auth::user()->email, [
        ' ' => $changes
    ]);

    return redirect('/posts')->with('success', 'Makale başarıyla güncellendi!');
}

public function destroy($id)
{
    $post = Post::findOrFail($id);

    Log::channel('db')->warning('Makale silindi: ' . $post->title . ' | Kullanıcı: ' . Auth::user()->email);

    $post->delete();

    return redirect('/posts')->with('success', 'Makale başarıyla silindi!');
}

    public function logTest()
    {
        Log::channel('db')->info('Veritabanı log testi başarılı!', [
            'user_id' => auth()->id(),
            'not' => 'Bu sadece test amaçlı bir log kaydıdır.'
        ]);

        return 'Log testi tamamlandı.';
    }
}
