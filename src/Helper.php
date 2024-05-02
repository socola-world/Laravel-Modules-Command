<?php

namespace SocolaDaiCa\LaravelModulesCommand;

use Illuminate\Contracts\Foundation\CachesConfiguration;

class Helper
{
    /**
     * Overwrite the existing configuration with the given configuration.
     *
     * @param string $path
     * @param string $key
     */
    public static function overwriteConfigFrom($path, $key)
    {
        if (!(app() instanceof CachesConfiguration && app()->configurationIsCached())) {
            $config = app()->make('config');

            $config->set($key, array_merge(
                $config->get($key, []),
                require $path
            ));
        }
    }

    public static function strRemoveZeroWidthCharacter($text)
    {
        return preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);
    }

    public static function overwrireModulesConfig()
    {
        Helper::overwriteConfigFrom(__DIR__.'/../config/modules.php', 'modules');
        \SocolaDaiCa\LaravelBadassium\Helpers\Helper::appendsConfig(
            'modules',
            __DIR__.'/../config/modules.php',
        );
        \SocolaDaiCa\LaravelBadassium\Helpers\Helper::appendsConfig(
            'modules',
            __DIR__.'/../config/laravel-modules-command.php',
        );
    }
}
