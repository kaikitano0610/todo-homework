# ベースイメージを指定
FROM php:8.1-fpm
# 作業ディレクトリを設定
WORKDIR /var/www
# 必要なパッケージのインストール。RUNでコマンドを実行する
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl
# PHPの拡張機能のインストール。LaravelはデフォルトでPDOを使用してデータベースに接続するからpdp_mysqlの拡張機能が必要らしい
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
# Composerのインストール。LaravelはComposerを使ってライブラリをインストールするからComposerが利用できる環境がいる
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# アプリケーションのコンテナにコピー
COPY . /var/www
# サーバーと連携してアプリケーションを実行するためにPHP-FPMを起動
CMD ["php-fpm"]
# コンテナ外からアクセスできるようにポートを公開
EXPOSE 9000
# オプコードキャッシュを有効化する
RUN docker-php-ext-install opcache
