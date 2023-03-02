<?php

namespace Inovector\MixpostAuth;

use Illuminate\Support\HtmlString;
use Inovector\MixpostAuth\Models\User;

class MixpostAuth
{
    static function assets()
    {
        $hot = __DIR__ . '/../resources/hot';

        $devServerIsRunning = file_exists($hot);

        if ($devServerIsRunning) {
            $viteServer = file_get_contents($hot);

            return new HtmlString(<<<HTML
                <script type="module" src="$viteServer/@vite/client"></script>
                <script type="module" src="$viteServer/resources/css/app.css"></script>
            HTML
            );
        }

        $manifest = json_decode(file_get_contents(
            public_path('vendor/mixpost-auth/manifest.json')
        ), true);

        return new HtmlString(<<<HTML
                <link rel="stylesheet" href="/vendor/mixpost-auth/{$manifest['resources/css/app.css']['file']}">
            HTML
        );
    }

    static function getUserClass(): string
    {
        return config('mixpost-auth.user_model', User::class);
    }
}
