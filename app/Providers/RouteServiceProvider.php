<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;

class RouteServiceProvider extends BaseServiceProvider
{
    /**
     * O namespace para os controladores.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Registra os serviços de roteamento.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Rotas para o grupo web
            Route::namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Rotas para o grupo API com o prefixo 'api'
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace . '\Api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Configura a limitação de taxa de requisições.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        // Configurações de limitação de taxa
    }

    /**
     * Registra os serviços de roteamento da aplicação.
     *
     * @return void
     */
    public function register()
    {
        // Registro de serviços ou bindings específicos
    }
}
