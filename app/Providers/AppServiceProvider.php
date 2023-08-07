<?php

namespace App\Providers;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        /**
         * for forcinf ssl in production. Used by Render
         * 
         */


         if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
        
       /* Paginate a standard Laravel Collection.
        *
        * @param int $perPage
        * @param int $total
        * @param int $page
        * @param string $pageName
        * @return array
        */
       
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
           $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
           
           return new LengthAwarePaginator(
               $this->forPage($page, $perPage),
               $total ?: $this->count(),
               $perPage,
               $page,
               [
                   'path' => LengthAwarePaginator::resolveCurrentPath(),
                   'pageName' => $pageName,
               ]
           );
       });
    }
}
