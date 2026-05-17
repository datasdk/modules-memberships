<?php

namespace Modules\Memberships\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Crm\Http\Controllers\Api\UserController;
use Modules\Memberships\Models\User as MemberUser;

use DataSDK\Categories\Http\Controllers\Api\CategoriesController;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\User;
use Lecturize\Addresses\Models\Address;
use Lecturize\Addresses\Models\Contact;
use Laravelcm\Subscriptions\SubscriptionServiceProvider;

use Modules\Memberships\Models\Subscription;
use Modules\Memberships\Observers\UserObserver;
use Modules\Memberships\Observers\FeatureObserver;
use Modules\Memberships\Models\Feature;
use Modules\Memberships\Observers\SubscriptionObserver;




use Settings;


class MembershipsServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Memberships';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'memberships';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        
        $this->commands([
            \Modules\Memberships\Console\Commands\CheckSubscriptionRenewals::class
        ]);


        $this->vendorProvioders();

        $this->registerObservers();


    }


    function vendorProvioders(){

        $this->app->register(SubscriptionServiceProvider::class);

    }


    public function registerObservers(){

        User::observe(UserObserver::class);

        Feature::observe(FeatureObserver::class);

        Subscription::observe(SubscriptionObserver::class);

    }    

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
 


        UserController::addInclude(["memberships","memberships.plan","subscriptions"]);

        CategoriesController::addInclude("membership");       
        

        User::resolveRelationUsing("memberships", function ($user) {
       
            return (new MemberUser())->subscriptions();

        });

        User::resolveRelationUsing('subscriptions', function (User $user) {

            return MemberUser::find($user->id)->planSubscriptions();

        });


     

    }


    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {

        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );

    }


    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {

        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {

        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {

            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);

        } else {

            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);

        }

    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }


    private function getPublishableViewPaths(): array
    {

        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }


}
