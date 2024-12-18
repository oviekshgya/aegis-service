<?php

namespace App\Mail;

use App\Models\users;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(users $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.admin_notification')
                    ->with([
                        'user_name' => $this->user->name,
                        'user_email' => $this->user->email,
                    ]);
    }
}
