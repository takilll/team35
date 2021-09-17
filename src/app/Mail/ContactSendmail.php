<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $title;
    private $nickname;
    private $mail;
    private $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $inputs )
    {
        $this->title = $inputs['title'];
        $this->nickname = $inputs['nickname'];
        $this->mail = $inputs['mail'];
        $this->body  = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('example@gmail.com')
        ->subject('自動送信メール')
        ->view('contact.mail')
        ->with([
            'title' => $this->title,
            'nickname' => $this->nickname,
            'mail' => $this->mail,
            'body' => $this->body,
        ]);
    }
}
