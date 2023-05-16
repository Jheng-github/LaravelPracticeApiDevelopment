<?
namespace App\Jobs;

use App\Mail\UserEmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     */
    //傳進來還需要 User $user嗎？
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dd($this->user);
        $user = User::find($this->user->id);

        if ($user) {
            Mail::to($user->email)->send(new UserEmailVerification($user));
            event(new Registered($user));
        }
    }
}
