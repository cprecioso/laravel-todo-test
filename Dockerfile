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

RUN install-php-extensions pdo_mysql

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /app
COPY --from=builder-node /app .

HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl -f http://localhost/up || exit 1

ARG APP_NAME
ENV APP_NAME=${APP_NAME}
ARG APP_URL
ENV APP_URL=${APP_URL}
ARG APP_ENV
ENV APP_ENV=${APP_ENV}
ARG APP_DEBUG
ENV APP_DEBUG=${APP_DEBUG}
ARG APP_KEY
ENV APP_KEY=${APP_KEY}
ARG DB_CONNECTION
ENV DB_CONNECTION=${DB_CONNECTION}
ARG DB_URL
ENV DB_URL=${DB_URL}
ARG LOG_CHANNEL
ENV LOG_CHANNEL=${LOG_CHANNEL}
ARG QUEUE_CONNECTION
ENV QUEUE_CONNECTION=${QUEUE_CONNECTION}

ENV VIEW_COMPILED_PATH=/app/app_cache/views
RUN php artisan optimize
