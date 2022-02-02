<?php

namespace GabrielWebStudio\Notifications\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    protected $signature = 'gws-notifications:install {--base : Only if you have already installed TailwindCss and AlpineJs}';

    protected $description = 'Install the package resources and NPM dependencies';

    protected $function = "window.removeNotification = function (e) {
    let block = e.parentNode.parentNode;
    block.classList.add('translate-x-full');
    block.classList.add('opacity-0');
    setTimeout(function() {
        block.remove();
    }, 500)
}";

    public function handle()
    {
        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    'alpinejs' => '^3.4.2',
                    'autoprefixer' => '^10.1.0',
                    'postcss' => '^8.2.1',
                    'postcss-import' => '^14.0.1',
                    'tailwindcss' => '^3.0.0',
                ] + $packages;
        });

        if(!$this->option('base')) {
            // Configuration Files
            copy(__DIR__.'/../../resources/tailwind.config.js', base_path('tailwind.config.js'));
            copy(__DIR__.'/../../resources/webpack.mix.js', base_path('webpack.mix.js'));
            copy(__DIR__.'/../../resources/css/app.css', resource_path('css/app.css'));
            copy(__DIR__.'/../../resources/js/app.js', resource_path('js/app.js'));
        } else {
            (new Filesystem())->append(resource_path('js/app.js'), $this->function);
        }

        (new Filesystem)->ensureDirectoryExists(base_path('config'));
        (new Filesystem)->copy(__DIR__ . '/../config/gabrielwebstudio.php', base_path('config/input.php'));

        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->copy(__DIR__ . '/../../resources/components/toast-notification.blade.php', resource_path('views/components/toast-notification.blade.php'));

        $this->info('Inputs scaffolding installed successfully.');

        if(!$this->option('base')) {
            $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
        }
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, bool $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
