<?php

return array_values(array_filter([
    App\Providers\AppServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    // Telescope is a dev package: production installs (composer --no-dev, e.g. on Vercel) don't have it
    class_exists(Laravel\Telescope\TelescopeApplicationServiceProvider::class)
        ? App\Providers\TelescopeServiceProvider::class
        : null,
]));
