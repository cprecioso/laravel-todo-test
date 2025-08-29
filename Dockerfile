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

FROM dunglas/frankenphp

WORKDIR /app
COPY --from=builder-node /app .

COPY .env.example .env

ENV APP_ENV=local
ENV APP_DEBUG=true
ENV APP_URL=https://localhost
ENV APP_KEY=base64:Mkg8106wR2x3HTJeyaxLH1YzwP90iYqQbu9qI3gj8kA=

RUN php artisan optimize
RUN php artisan migrate --force --seed

HEALTHCHECK --interval=5s --timeout=3s \
  CMD curl -f http://localhost/up || exit 1

VOLUME "/app/bootstrap/cache"
VOLUME "/app/storage"
