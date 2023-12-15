<?php

namespace App\Modules\Services;

use App\Mail\ChannelMessage;
use App\Models\Message;
use App\Models\User;
use App\Modules\InterFaces\NotificationService\NotificationService;
use Illuminate\Support\Facades\Mail;

class EmailService implements NotificationService
{

    public static function send(User $user, Message $message)
    {
        Mail::to($user->email)->queue(new ChannelMessage($message));
    }
}
