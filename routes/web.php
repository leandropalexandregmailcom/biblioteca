<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;

Route::post('api/register', [AuthController::class, 'register']);
Route::post('api/login', [AuthController::class, 'login']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'api'

], function ($router) {
    $router->get('bookIndex', [BookController::class, 'bookIndex']);
    $router->post('bookStore', [BookController::class, 'bookStore']);
    $router->get('bookShow/{id}', [BookController::class, 'bookShow']);
    $router->put('bookUpdate/{id}', [BookController::class, 'bookUpdate']);
    $router->delete('bookDestroy/{id}', [BookController::class, 'bookDestroy']);

    $router->get('loanIndex', [LoanController::class, 'loanIndex']);
    $router->post('loanStore', [LoanController::class, 'loanStore']);
    $router->get('loanShow/{id}', [LoanController::class, 'loanShow']);
    $router->put('loanUpdate/{id}', [LoanController::class, 'loanUpdate']);
    $router->delete('loanDestroy/{id}', [LoanController::class, 'loanDestroy']);

    $router->get('authorIndex', [AuthorController::class, 'authorIndex']);
    $router->post('authorStore', [AuthorController::class, 'authorStore']);
    $router->get('authorShow/{id}', [AuthorController::class, 'authorShow']);
    $router->put('authorUpdate/{id}', [AuthorController::class, 'authorUpdate']);
    $router->delete('authorDestroy/{id}', [AuthorController::class, 'authorDestroy']);
    $router->patch('authorPartialUpdate/{id}', [AuthorController::class, 'authorUpdatePartial']);
});

