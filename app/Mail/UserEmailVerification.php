<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Mail\Mailables\Address;


class UserEmailVerification extends Mailable
{
    use Queueable, SerializesModels;


    protected $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '您已經成功發信',
            //可以選擇在這邊加入,也可以透過Config/mail.php  寄件者資訊
            //  from: new Address('jeffrey@example.com', 'Jeffrey Way'), 
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {   
        //顯示view , 其位志在 resources/views/email.blade.php 
        //也可以在view底下在創建一個 email檔案比較好規劃 路徑則變 resources/views/email/email.blade.php
        return new Content(
            view: 'email',
            //這樣就可以固定住user這個字串去取得user的哪一個資料了
            with: [
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
