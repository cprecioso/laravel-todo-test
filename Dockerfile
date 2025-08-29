# syntax=docker/dockerfile:1

FROM alpine/git AS cloner

COPY --link . /app

WORKDIR /app
RUN <<EOF
    if [ -d .git ]; then
        git clean -fdx
        rm -rf .git
    fi
EOF

FROM composer AS builder-php

WORKDIR /app
COPY --from=cloner /app .

RUN composer install --no-dev --optimize-autoloader

FROM node AS builder-node

WORKDIR /app
COPY --from=builder-php /app .

ENV NODE_ENV=production
RUN npm ci
RUN npm run build

FROM dunglas/frankenphp

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /app
COPY --from=builder-node /app .

HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl -f http://localhost/up || exit 1

ENV VIEW_COMPILED_PATH=/app/app_cache/views
RUN php artisan optimize
