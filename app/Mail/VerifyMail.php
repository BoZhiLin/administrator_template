<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Defined\SystemDefined;
use App\Models\User;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【會員驗證信通知】')
            ->view('email.verify', [
                'user' => $this->user,
                'code' => $this->code,
                'expires' => SystemDefined::VERIFY_CODE_EXPIRED
            ]);
    }
}
