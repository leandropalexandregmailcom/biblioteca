<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Adiciona os cabeçalhos CORS à resposta
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ];

        // Verifica se a solicitação é do tipo OPTIONS
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200)->withHeaders($headers);
        }

        // Adiciona os cabeçalhos CORS à resposta da solicitação normal
        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
