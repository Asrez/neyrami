<?php

namespace App\Providers;

use App\Interfaces\AuthenticationInterfaceMail;
use App\Interfaces\AuthenticationInterfacePhone;
use App\Interfaces\ProfileRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryEmail;
use App\Repositories\Auth\AuthRepositoryPhone;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\WebService\InterFaces\ManageVideo;
use App\Repositories\WebService\InterFaces\SendInterFace;
use App\Repositories\WebService\Repositories\ManageRepositories;
use App\Repositories\WebService\Repositories\Send;
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
        $this->app->bind(ManageVideo::class, ManageRepositories::class);
        $this->app->bind(SendInterFace::class, Send::class, );
        $this->app->bind(AuthenticationInterfacePhone::class, AuthRepositoryPhone::class);
        $this->app->bind(AuthenticationInterfaceMail::class, AuthRepositoryEmail::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
