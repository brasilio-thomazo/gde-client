<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    private function create_db()
    {
        $config = [
            'driver'    => env('DB_CONNECTION'),
            'host'      => env('DB_HOST'),
            'database'  => null,
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
        ];

        config(['database.connections.temp' => $config]);
        config(['database.default' => 'temp']);
        if (env('DB_CONNECTION') == 'mysql')
            DB::statement('create database if not exists ' . env('DB_DATABASE'));
        else
            DB::statement('create database ' . env('DB_DATABASE'));
    }

    public function migrate()
    {
        try {
            Artisan::call('migrate');
            Artisan::call('db:seed');
            return response(['result', trim(Artisan::output())], 201);
        } catch (Exception $ex) {
            try {
                $this->create_db();
                config(['database.default' => env('DB_CONNECTION')]);
                Artisan::call('migrate');
                return response(['result', trim(Artisan::output())], 201);
            } catch (Exception $ex) {
                return response(['message' => trim($ex->getMessage())], 400);
            }
        }
    }

    public function migrate_fresh()
    {
        try {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed');
            return response(['result', trim(Artisan::output())], 200);
        } catch (Exception $ex) {
            try {
                $this->create_db();
                config(['database.default' => env('DB_CONNECTION')]);
                Artisan::call('migrate:fresh');
                return response(['result', trim(Artisan::output())], 200);
            } catch (Exception $ex) {
                return response(['message' => trim($ex->getMessage())], 400);
            }
        }
    }
}
