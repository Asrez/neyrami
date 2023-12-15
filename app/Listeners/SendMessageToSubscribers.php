<?php

namespace App\Listeners;

use App\Events\MessagePosted;
use App\Mail\ChannelMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendMessageToSubscribers implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    protected $notificationServices;

    public function __construct()
    {

    }

    public function handle(MessagePosted $event)
    {
        \Log::info(response()->json($event->message->channel->subscribers, 200));
        $subscribers = $event->message->channel->subscribers;

        foreach ($subscribers as $subscriber) {
            $service = "App\\Modules\\Services\\" . Str::ucfirst($subscriber->enabled_notification_service) . "Service";

            if ($service) {
                \Closure::fromCallable([$service, 'send'])($subscriber, $event->message);
            }
        }
    }
}
