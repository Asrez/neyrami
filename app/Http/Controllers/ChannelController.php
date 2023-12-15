<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use App\Http\Requests\Channels\CreateUniqeChannelRequest;
use App\Http\Requests\Messages\MseesageStoreRequest;
use App\Models\Channel;
use App\Modules\InterFaces\ChannelRepositoryInterFace;
use App\Modules\InterFaces\MessageRepositoryInterFace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    protected $channelRepository;
    protected $messageRepository;

    public function __construct(ChannelRepositoryInterFace $channelRepository,MessageRepositoryInterFace $messageRepository){
        $this->channelRepository = $channelRepository;
        $this->messageRepository = $messageRepository;
    }

    public function index()
    {
        $channels = $this->channelRepository->all();
        return response()->json($channels, 200);
    }

    public function store(CreateUniqeChannelRequest $request)
    {

        $channel = $this->channelRepository->create([
            'user_id' => auth('api')->user()->id,
            'name' => $request->name,
            'identifier' => $this->createIdentifireUniqeChannel($request->name),
            'image' => $request->image,
        ]);
        return response()->json($channel, 201);
    }

    protected function createIdentifireUniqeChannel($name)
    {
        $identifire = str_replace(' ', '-', $name);
        $identifire = preg_replace('/[^A-Za-z0-9\-]/', '', $identifire);
        $identifire = strtolower($identifire);
        $identifire = substr($identifire, 0, 20);
        $identifire = $identifire . '-' . uniqid();
        return $identifire;
    }

    public function getChannelByIdentifire($identifire)
    {
        $channel = $this->channelRepository->model()->where('identifire', $identifire)->first();
        return response()->json($channel, 200);
    }

    public function getChannelById($id)
    {
        $channel = $this->channelRepository->find($id);
        return response()->json($channel, 200);
    }

    public function uploadeImageWidthStorage(Request $request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('images', $image, $imageName);
        return response()->json(['image' => $imageName], 200);
    }

    //subscribe to a channel

    public function subscribe(Request $request,Channel $channel)
    {
        $channel = $this->channelRepository->model()->where('id', $channel->id)->first();

        $channel->subscribers()->attach(auth('api')->user()->id);
        return response()->json(['message' => 'You have subscribed to this channel'], 200);
    }




    public function storeMessage(MseesageStoreRequest $request, Channel $channel)
    {
        if ($channel->user_id != auth('api')->user()->id) {
            return response()->json(['message' => 'شما صاحب این کانال نیستید'], 403);
        }

        $message = $this->messageRepository->create([
            'user_id' => auth('api')->user()->id,
            'channel_id' => $channel->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        event(new MessagePosted($message));
//        broadcast(new MessagePosted($message, auth('api')->user()))->toOthers();

        return response()->json(['message' => 'پیام با موفقیت ایجاد شد.'], 201);
    }


}
