# syntax=docker/dockerfile:1

FROM alpine/git AS cloner

RUN --mount=type=bind,target=/src <<EOF
    git clone --depth 1 /src /app
    rm -rf /app/.git
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

FROM dunglas/frankenphp AS base

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /app
COPY --from=builder-node /app .

FROM base AS artisan

ENTRYPOINT [ "php", "artisan" ]

FROM artisan AS migrator

CMD ["migrate", "--force", "--seed"]

FROM base AS app

HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl -f http://localhost/up || exit 1

VOLUME "/app/bootstrap/cache"
VOLUME "/app/storage"
