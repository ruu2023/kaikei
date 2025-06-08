# 開発チケット一覧

## 高優先度（Phase 1 - MVP必須機能）

### TICKET-001 [フロントエンド] ダッシュボードページの実装
**ファイル**: `resources/views/pages/dashboard.blade.php`
**概要**: accounting-dashboardのindex.htmlを参考に、月次収支サマリー、最近の取引表示を実装
**詳細**:
- 月次収支カード（今月の収支、前月比）
- 最近の取引一覧（最新5件）
- レスポンシブレイアウト
**依存関係**: TICKET-002の完了後に実装可能

### TICKET-002 [バックエンド] AppController::dashboard()メソッドの実装
**ファイル**: `app/Http/Controllers/AppController.php`
**概要**: ダッシュボードページに必要なデータを取得・計算するロジック
**詳細**:
- 今月・前月の収支計算
- 前月比計算
- 最近の取引データ取得（リレーションを含む）
- チャートデータ準備
**依存関係**: なし（独立して実装可能）

### TICKET-003 [フロントエンド] 分析ページの実装
**ファイル**: `resources/views/pages/analytics.blade.php`
**概要**: accounting-dashboardのanalytics.htmlを参考に分析機能を実装
**詳細**:
- 期間選択機能
- 月次サマリーカード
- 取引一覧表示
- フィルター機能（収支、科目、期間）
- 取引編集・削除モーダル
**依存関係**: TICKET-004の完了後に実装可能

### TICKET-004 [バックエンド] AppController::analytics()メソッドの実装
**ファイル**: `app/Http/Controllers/AppController.php`
**概要**: 分析ページのデータ取得とフィルター処理
**詳細**:
- 期間別取引データ取得
- 科目別集計
- フィルター条件処理
- ページネーション対応
**依存関係**: なし（独立して実装可能）

## 中優先度（Phase 2 - 機能強化）

### TICKET-005 [フロントエンド] Chart.jsグラフ表示機能の実装
**ファイル**: `resources/js/app.js`, `resources/views/pages/dashboard.blade.php`, `resources/views/pages/analytics.blade.php`
**概要**: Chart.jsを使用したグラフ表示機能
**詳細**:
- 収支棒グラフ（月次推移）
- 科目別円グラフ
- グラフ切り替え機能
**依存関係**: TICKET-001, TICKET-003の完了後

### TICKET-006 [バックエンド] 仕訳帳CSV出力機能の実装
**ファイル**: `app/Http/Controllers/TransactionController.php`, `routes/web.php`
**概要**: 税務対応のための仕訳帳CSV出力機能
**詳細**:
- 期間指定CSV出力
- 仕訳形式でのデータ整形
- ダウンロード機能
**依存関係**: なし（独立して実装可能）

### TICKET-007 [フロントエンド] 静的CSSのLaravelアセット統合
**ファイル**: `resources/sass/`, `vite.config.js`
**概要**: accounting-dashboardのCSSをLaravelのアセットビルドに統合
**詳細**:
- styles.css → app.scss
- analytics.css → analytics.scss  
- settings.css → settings.scss
- transaction.css → transaction.scss
- Vite設定更新
**依存関係**: なし（独立して実装可能）

### TICKET-008 [フロントエンド] JavaScript機能のBladeテンプレート統合
**ファイル**: `resources/js/`, Bladeテンプレート各種
**概要**: accounting-dashboardのJavaScript機能をLaravelに統合
**詳細**:
- モーダル制御
- フォーム送信処理
- 動的UI更新
- イベントリスナー設定
**依存関係**: TICKET-007の完了後

### TICKET-009 [フロントエンド] ナビゲーションリンクのLaravelルート統一
**ファイル**: 全Bladeテンプレート
**概要**: 静的HTMLリンクをLaravelルートに置き換え
**詳細**:
- bottom-navのリンク修正
- route()ヘルパー使用
- アクティブ状態の制御
**依存関係**: なし（独立して実装可能）

### TICKET-010 [バックエンド] TransactionController の取引編集・削除機能強化
**ファイル**: `app/Http/Controllers/TransactionController.php`
**概要**: 取引の編集・削除機能の強化
**詳細**:
- update()メソッド実装
- destroy()メソッド実装
- バリデーション強化
- エラーハンドリング
**依存関係**: なし（独立して実装可能）

## 低優先度（Phase 3 - 追加機能）

### TICKET-011 [フロントエンド] 予算管理機能の実装
**ファイル**: `resources/views/pages/dashboard.blade.php`, 関連Controller
**概要**: ダッシュボードの予算進捗機能
**詳細**:
- 予算設定機能
- 進捗バー表示
- 警告表示
**依存関係**: TICKET-001, TICKET-002の完了後

### TICKET-012 [テスト] 基本機能のテストケース作成
**ファイル**: `tests/Feature/`, `tests/Unit/`
**概要**: 主要機能のテストケース作成
**詳細**:
- 取引CRUD操作テスト
- CSV出力テスト
- 認証テスト
**依存関係**: 各機能実装完了後

## 並行開発の推奨パターン

### パターン1: フロントエンド・バックエンド分離
- 開発者A: TICKET-002, TICKET-004, TICKET-006, TICKET-010
- 開発者B: TICKET-001, TICKET-003, TICKET-005, TICKET-007

### パターン2: 機能別分担
- 開発者A: ダッシュボード関連（TICKET-001, TICKET-002, TICKET-011）
- 開発者B: 分析機能関連（TICKET-003, TICKET-004, TICKET-005）

### パターン3: レイヤー別分担
- 開発者A: バックエンド（TICKET-002, TICKET-004, TICKET-006, TICKET-010）
- 開発者B: フロントエンド（TICKET-001, TICKET-003, TICKET-007, TICKET-008, TICKET-009）

## 注意点

1. **TICKET-001とTICKET-002は密結合**: データ構造を事前に合意
2. **TICKET-003とTICKET-004は密結合**: APIインターフェースを事前に合意
3. **TICKET-007完了後にTICKET-008実装**: CSS統合後にJS統合
4. **共通コンポーネント**: モーダル、フォーム部品は事前に設計合意

## 完了条件

各チケットは以下を満たした時点で完了とする：
- 機能が正常に動作する
- accounting-dashboardと同等の見た目・操作性
- コードレビュー完了
- 簡単な動作確認完了