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
        $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
        // 画像のurlを取得する
        $post->image = Storage::disk('s3')->url($path);
        $post->save();
        return $post;

        $message = new Message;
        // input()は、連想配列で返す
        //input('カラム')でリクエストクラスに入った値を取得すr
        $message->name = $request->input('name');
        $message->content = $request->input('content');
        $image =  $request->file("image");
        // $imageを、myprefixというディレクトリに'public'という名前ど保存
        $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
        // 画像のurlを取得する
        $message->image = Storage::disk('s3')->url($path);
        // store()からファイルパスが返ってくる

        //str_replaceメソッドで、filePathから、public以下を消去して、imageに格納
        // hasは、リクエストに値が存在しているかどうかチェックするための関数
        // $request->has('content')
        $message->save();
        return redirect('/');
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);
        $post->content = $request->input('content');
        $post->update();
        return $post;
    }
    //
}
