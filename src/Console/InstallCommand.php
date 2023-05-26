<?php

namespace OpenStrong\StrongAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'strongadmin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '安裝 StrongAdmin';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing StrongAdmin Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'strongadmin-provider']);

        $this->comment('Publishing StrongAdmin Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'strongadmin-assets']);

        $this->comment('Publishing StrongAdmin Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'strongadmin-config']);

        $this->registerStrongAdminServiceProvider();
        $this->registerStrongAdminAuthGuard();

        $this->info('StrongAdmin scaffolding installed successfully.');
    }

    /**
     * Register the StrongAdmin service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerStrongAdminServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\StrongAdminServiceProvider::class')) {
            return;
        }

        $lineEndingCount = [
            "\r\n" => substr_count($appConfig, "\r\n"),
            "\r" => substr_count($appConfig, "\r"),
            "\n" => substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol,
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol."        {$namespace}\Providers\StrongAdminServiceProvider::class,".$eol,
            $appConfig
        ));

        file_put_contents(app_path('Providers/StrongAdminServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/StrongAdminServiceProvider.php'))
        ));
    }
    
    /**
     * 註冊 StrongAdmin Auth Guard 看守器
     *
     * @return void
     */
    protected function registerStrongAdminAuthGuard()
    {
        $appConfig = file_get_contents(config_path('auth.php'));

        if (Str::contains($appConfig, '\\OpenStrong\\StrongAdmin\\Models\\AdminUser::class')) {
            return;
        }
        
        $lineEndingCount = [
            "\r\n" => substr_count($appConfig, "\r\n"),
            "\r" => substr_count($appConfig, "\r"),
            "\n" => substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];
        
        $guard = config('strongadmin.guard');
        
        $appConfig = str_replace(
            "'guards' => [".$eol,
            "'guards' => [".$eol."        '{$guard}' => [
            'driver' => env('STRONGADMIN_GUARDS_DRIVER', 'session'),
            'provider' => '{$guard}s',
        ],".$eol.$eol,$appConfig);
        $appConfig = str_replace(
            "'providers' => [".$eol,
            "'providers' => [".$eol."        '{$guard}s' => [
            'driver' => 'eloquent',
            'model' => \OpenStrong\StrongAdmin\Models\AdminUser::class,
        ],".$eol.$eol,$appConfig);
        file_put_contents(config_path('auth.php'), $appConfig);
    }
}
