<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    public $nickname;
    public $to_nickname;
    public $mail;
    public $title;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->nickname = $inputs['nickname'];
        $this->to_nickname = $inputs['to_nickname'];
        $this->mail = $inputs['mail'];
        $this->title  = $inputs['title'];
        $this->body = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('business.test.0820@gmail.com')
            ->subject('問い合わせがありました')
            ->view('contact.mail')
            ->with([
                'nickname' => $this->nickname,
                'to_nickname' => $this->to_nickname,
                'mail' => $this->mail,
                'title' => $this->title,
                'body'  => $this->body,
            ]);
    }
}
