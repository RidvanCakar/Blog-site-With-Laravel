<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{   
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required'
        ]);

        try {
            $comment = Comment::create([
                'content' => $request->content,
                'user_id' => Auth::id(),
                'post_id' => $postId,
            ]);

            // Veritabanına log kaydı
            Log::channel('db')->info("Yeni yorum eklendi: ID={$comment->id} | Kullanıcı=" . Auth::user()->email);

            return back()->with('success', 'Yorum başarıyla eklendi!');
        } catch (\Exception $e) {
            // Veritabanına hata logu
            Log::channel('db')->error("Yorum ekleme hatası: " . $e->getMessage());

            return back()->with('error', 'Yorum eklenirken bir hata oluştu.');
        }
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        Log::channel('db')->warning('Yorum silindi: ' . $comment->content . ' | Kullanıcı: ' . Auth::user()->email);

        $comment->delete();

        return back()->with('success', 'Yorum başarıyla silindi!');
    }


}
