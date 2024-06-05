# 宿題管理ツール

## 概要

このプロジェクトは、xampp環境で動作するウェブアプリケーションです。以下の手順に従って、開発環境を構築し、アプリケーションを実行することができます。

## 前提条件

- [XAMPP](https://www.apachefriends.org/index.html) がインストールされていること
- [Node.js](https://nodejs.org/) がインストールされていること
- [Composer](https://getcomposer.org/) がインストールされていること

## セットアップ手順

1. **リポジトリをクローン**
    ```bash
    git clone https://github.com/kaikitano0610/todo-homework.git
    ```

2. **依存関係をインストール**
    - **Node.js パッケージ**
        ```bash
        npm install
        ```
    - **PHP パッケージ**
        ```bash
        composer install
        ```

3. **環境変数を設定**
    - `.env.example` ファイルを `.env` にコピーし、必要に応じて設定を変更します。
        ```bash
        cp .env.example .env
        ```

4. **データベースの設定**
    - XAMPPコントロールパネルからMySQLを起動します。
    - データベースを作成します。
        ```sql
        CREATE DATABASE your_database_name;
        ```
    - `.env` ファイルの `DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD` を設定します。

5. **データベースのマイグレーションとシーディング**
    ```bash
    php artisan migrate --seed
    ```

## 開発環境の起動

1. **フロントエンドのビルドとウォッチ**
    ```bash
    npm run dev
    ```

2. **ローカルサーバーの起動**
    ```bash
    php artisan serve
    ```

## アクセス

ブラウザで以下のURLにアクセスします。

http://localhost:8000



