<?php
namespace App\Http\Controllers\Api\V1_0;


use Illuminate\Http\Request;
use App\Post;
use App\Http\Controllers\Controller;
use Storage;


class PostsController extends Controller
{
    public function index() {
        $posts = Post::all();
        // apimodeでデータを返す
        return $posts;
    }

    public function show($id) {
      $post = Post::find($id);
      return $post;
    }

    public function store(Request $request) {
        $post = new Post;
        $post->content = $request->input('content');
        $image = $request->file("image");
        // $imageを、myprefixというディレクトリに'public'という名前ど保存
        $path = Storage::disk('s3')->putFile('kanly-practice-s3', $image, 'public');
        // 画像のurlを取得する
        $post->image = Storage::disk('s3')->url($path);
        $post->save();
        return $post;
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);
        $post->content = $request->input('content');
        $post->update();
        return $post;
    }
    //
}
