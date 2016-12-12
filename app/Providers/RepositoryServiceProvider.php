<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use App\Repositories\Point\PointRepository;
use App\Repositories\Point\PointRepositoryInterface;

use App\Repositories\Promotion\PromotionRepository;
use App\Repositories\Promotion\PromotionRepositoryInterface;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(PointRepositoryInterface::class, PointRepository::class);

        App::bind(PromotionRepositoryInterface::class, PromotionRepository::class);

        App::bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
