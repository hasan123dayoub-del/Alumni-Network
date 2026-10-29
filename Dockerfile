# Demo deployment image: Laravel API on SQLite, seeded with demo data on every boot.
# No Redis, Pusher or mail server on the free tier: cache is in memory, queued jobs run inline,
# broadcasts and emails go to the log.

# 1) PHP dependencies. Dev packages are included because the demo seeders use Faker and
#    TelescopeServiceProvider is registered in bootstrap/providers.php.
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --prefer-dist --no-interaction --ignore-platform-reqs

# 2) Runtime (the lock file needs PHP 8.4)
FROM php:8.4-cli
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=vendor /app/vendor ./vendor
RUN composer dump-autoload --optimize --no-interaction \
    && chmod +x docker/start.sh

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=sqlite \
    QUEUE_CONNECTION=sync \
    CACHE_STORE=array \
    SESSION_DRIVER=array \
    BROADCAST_CONNECTION=log \
    MAIL_MAILER=log \
    TELESCOPE_ENABLED=false \
    PHP_CLI_SERVER_WORKERS=4

EXPOSE 8000
CMD ["docker/start.sh"]
