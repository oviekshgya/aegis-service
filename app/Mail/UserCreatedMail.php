<?php

namespace App\Mail;

use App\Models\users;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(users $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.users_created')
                    ->with([
                        'user_name' => $this->user->name,
                    ]);
    }
}
