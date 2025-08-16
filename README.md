# 会計管理ダッシュボード

個人事業主向けの会計管理アプリケーションです。日々の取引を記録し、収支を可視化することで、確定申告の準備をサポートします。

## 主な機能

- **ダッシュボード**: 月次の収支サマリー、前月比較、収支グラフなどを表示します。
- **取引管理**: 収入・支出の取引を登録、編集、削除できます。
- **科目管理**: 勘定科目を自由にカスタマイズできます。
- **分析機能**: 期間や科目でフィルタリングし、収支をグラフで分析できます。
- **データエクスポート**: 取引データをCSV形式で出力でき、仕訳帳として利用可能です。

## 使用技術

### バックエンド
- PHP 8.2
- Laravel 11
- SQLite

### フロントエンド
- Vite
- Tailwind CSS
- Alpine.js
- Chart.js

## 環境構築手順

1. **リポジトリをクローン**
   ```bash
   git clone https://github.com/m-shiraishi/kaikei.git
   cd kaikei
   ```

2. **依存関係をインストール**
   ```bash
   composer install
   npm install
   ```

3. **環境ファイルの設定**
   `.env.example` ファイルをコピーして `.env` ファイルを作成します。
   ```bash
   cp .env.example .env
   ```

4. **アプリケーションキーの生成**
   ```bash
   php artisan key:generate
   ```

5. **データベースの準備**
   SQLiteデータベースファイルを作成し、マイグレーションとシーディングを実行します。
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **フロントエンドアセットのビルド**
   ```bash
   npm run build
   ```

## アプリケーションの実行

以下のいずれかのコマンドで開発サーバーを起動します。

- **PHPのビルトインサーバーで起動**
  ```bash
  php artisan serve
  ```

- **Viteと同時に起動（推奨）**
  `composer.json` の `dev` スクリプトを使用すると、PHPサーバー、Vite、キューリスナーなどが同時に起動し便利です。
  ```bash
  composer run dev
  ```

アプリケーションは `http://127.0.0.1:8000` で利用可能になります。

## テストの実行

以下のコマンドでPHPUnitのテストスイートを実行します。
```bash
php artisan test
```

## ライセンス

このプロジェクトは [MITライセンス](https://opensource.org/licenses/MIT) の下で公開されています。
