<?php

namespace App\Providers;

use Illuminate\Database\Connectors\PostgresConnector;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix: Supavisor pooler rejects dbname='postgres' (with quotes).
        // Override the pgsql connector to remove single quotes around dbname.
        $this->app->bind('db.connector.pgsql', function () {
            return new class extends PostgresConnector {
                protected function getDsn(array $config)
                {
                    extract($config, EXTR_SKIP);

                    $host = isset($host) ? "host={$host};" : '';

                    $database = $connect_via_database ?? $database;
                    $port = $connect_via_port ?? $port ?? null;

                    $dsn = "pgsql:{$host}dbname={$database}";

                    if (! is_null($port)) {
                        $dsn .= ";port={$port}";
                    }

                    if (isset($charset)) {
                        $dsn .= ";client_encoding='{$charset}'";
                    }

                    if (isset($application_name)) {
                        $dsn .= ";application_name='".str_replace("'", "\'", $application_name)."'";
                    }

                    return $this->addSslOptions($dsn, $config);
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
