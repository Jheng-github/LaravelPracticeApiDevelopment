<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
       $backUrl = $this->verificationUrl($notifiable);//這串是有api前綴字的url

       $url = Str::remove("api/", $backUrl); //把api 前綴字拿掉,hash應該是會躲過這些關鍵字的,所以使用上算安全

        return (new MailMessage)//偷過來的
            ->subject(Lang::get('Verify Email Address'))//偷過來的
            ->line(Lang::get('Please click the button below to verify your email address.'))//偷過來的
            ->action(Lang::get('Verify Email Address'), $url)//在驗證信樣板上的url就不會有api了
            ->line(Lang::get('If you did not create an account, no further action is required.'));//偷過來的
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    protected function verificationUrl($notifiable) //都偷過來的
    {
        // if (static::$createUrlCallback) { 這邊用不到可以刪掉
        //     return call_user_func(static::$createUrlCallback, $notifiable);這邊用不到可以刪掉
        // }這邊用不到可以刪掉
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
