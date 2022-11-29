<?php

namespace App\Models;

use Spatie\YamlFrontMatter\YamlFrontMatter;

if (app()->environment() == 'local') {
    class Layouts
    {
        public static function config()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/config.md'));
        }

        public static function pages()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/_qa/pages.md'))->matter();
        }

        public static function screens()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/screens.md'));
        }

        public static function navs()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/navs.md'))->matter();
        }

        public static function socials()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/socials.md'))->matter();
        }

        public static function coaches()
        {
            return YamlFrontMatter::parseFile(resource_path('_data/_qa/coaches.md'))->matter();
        }
    }
}
