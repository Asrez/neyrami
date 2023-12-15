<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channel\ChannelSubscriber;
use App\Http\Requests\Channel\ChannelUnSubscriber;
use App\Modules\InterFaces\ChannelRepositoryInterFace;
use App\Modules\InterFaces\UserRepositoryInterface;
use App\Modules\Repository\ChannelRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    protected $channelRepository;

    public function __construct(UserRepositoryInterface $userRepository ,ChannelRepositoryInterFace $channelRepository) {
        $this->userRepository = $userRepository;
        $this->channelRepository = $channelRepository;

    }

    public function subscribeToChannel(ChannelSubscriber $subscriber)
    {
       $data = $this->channelRepository->model()->subscribers()->attach(auth('api')->user()->id);
        return response()->json(['message' => 'Subscribed',$data], 200 );
    }

    public function unsubscribeFromChannel(ChannelUnSubscriber $unSubscriber)
    {
       $data = $this->channelRepository->model()->subscribers()->detach(auth('api')->user()->id);
        return response()->json(['message' => 'Unsubscribed',$data], 200 );
    }



}
