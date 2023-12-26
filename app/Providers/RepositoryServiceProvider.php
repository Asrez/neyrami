<?php

namespace App\Providers;


use App\Modules\InterFaces\ChannelRepositoryInterFace;
use App\Modules\InterFaces\MessageRepositoryInterFace;
use App\Modules\InterFaces\MsgRecevedRepoInterFace;
use App\Modules\InterFaces\UserRepositoryInterface;
use App\Modules\Repository\ChannelRepository;
use App\Modules\Repository\MessageRecivedRepository;
use App\Modules\Repository\MessageRepository;
use App\Modules\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageRepositoryInterFace::class, MessageRepository::class);
        $this->app->bind(ChannelRepositoryInterFace::class, ChannelRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MsgRecevedRepoInterFace::class, MessageRecivedRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
