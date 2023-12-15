<?php

namespace App\Jobs;

use App\Mail\ChannelMessage;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $channel;
    public function __construct($user, $channel)
    {
        $this->user = $user;
        $this->channel = $channel;
    }

    public function handle()
    {
        // Check if the email has already been sent
        $sentEmails = Subscription::where('user_id', $this->user->id)
            ->where('channel_id', $this->channel->id)
            ->first();
        if (!$sentEmails) {
            Mail::to($this->user->email)->send(new ChannelMessage($this->channel));


            Subscription::create([
                'user_id' => $this->user->id,
                'channel_id' => $this->channel->id,
            ]);
        }
    }
}
