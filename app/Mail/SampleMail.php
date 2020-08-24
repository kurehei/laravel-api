<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // 引数で受け取る値を設定
    protected $content;

    public function __construct($content)
    {
        // コンストラクタ
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // メールの文章について
        return $this
        ->from('example@s-p-net.com')
        ->subject('テスト送信')
        ->view('mail.send')
        ->with(['content'=> $this->content]);
        // viewに変数を渡す
    }
}
