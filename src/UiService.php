<?php

namespace Cube\Ui;

use Cube\App\App;
use Cube\App\Directory;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class UiService
{
    public static function install(OutputInterface $output)
    {
        self::installDependencies($output);
        self::configureFiles($output);
        self::moveResources($output);
    }

    protected static function installDependencies(OutputInterface $output)
    {
        $output->writeln('<fg=yellow>Installing dependencies...</>');
        $npm_init = 'npm init -y';
        $commands = array(
            'npm i -D vite vite-plugin-live-reload @vitejs/plugin-vue tailwindcss postcss autoprefixer',
            'npm i vue'
        );

        $base_dir = App::getRunningInstance()->getPath(
            Directory::PATH_ROOT
        );

        $package_json_dir = concat($base_dir . '/' . 'package.json');

        if (!file_exists($package_json_dir)) {
            array_unshift($commands, $npm_init);
        }

        $process =  Process::fromShellCommandline(
            implode(' && ', $commands)
        );

        $process->run(function () {
            echo '.';
        });

        echo "\n";
        $output->writeln('<fg=green>Dependencies installed successfully...</>');
    }

    protected static function configureFiles(OutputInterface $output)
    {
        echo "\n";
        $output->writeln('<fg=yellow>Setting up files...</>');

        $app = App::getRunningInstance();
        $dir = $app->getPath(Directory::PATH_ROOT);
        $copy_dir = __DIR__ . '/stubs/config/';

        $move_config = function ($name) use ($copy_dir, $dir) {

            $filename = $dir . '/' . $name;

            if (file_exists($filename)) {
                return;
            };

            copy($copy_dir . '/' . $name . '.stub', $filename);
        };

        $move_config('vite.config.js');
        $move_config('tailwind.config.js');
        $move_config('postcss.config.js');
        $output->writeln('<fg=green>Files setup complete...</>');
    }

    protected static function moveResources(OutputInterface $output)
    {
        echo "\n";
        $output->writeln('<fg=yellow>Preparing resources...</>');
        $app = App::getRunningInstance();
        $dir = $app->getPath(Directory::PATH_ROOT);
        $resources_dir = $dir . '/src';

        if (!is_dir($resources_dir)) {
            mkdir($resources_dir, 0755);
        }

        $copy_dir = __DIR__ . '/stubs/resources';
        $move_resources = function ($name) use ($copy_dir, $resources_dir) {
            $filename = $resources_dir . '/' . $name;

            if (file_exists($filename)) {
                return;
            }

            copy($copy_dir . '/' . $name . '.stub', $filename);
        };

        $move_resources('app.css');
        $move_resources('app.js');
        $move_resources('App.vue');

        $components_dir = $resources_dir . '/components';

        if (!is_dir($components_dir)) {
            mkdir($components_dir, 0755);
        }

        $move_resources('components/ExampleComponent.vue');
        $output->writeln('<fg=green>Resources prepared successfully...</>');
    }
}
