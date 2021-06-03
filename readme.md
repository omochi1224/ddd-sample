# DDD Laravel sample

DDD（オニオンアーキテクチャ、CQRS)を導入したLaravel

# Features

機能ごとにPackage管理することが可能なのでその他のアーキテクチャも簡単に導入可

# Requirement

* PHP 8

# Usage

```bash
git clone https://github.com/omochi1224/ddd-sample.git
cd ddd-sample
cp .env.example .env
touch database/database.sqlite
composer install -vvv
php artisan key:generate
php artisan serve
```

新規機能(パッケージ)追加
```bash
php artisan make:feature
```

すべてのテスト実行
```bash
composer test
```

コードが整形リスト
```bash
composer sniffer
```

コードが整形リストCSV
```bash
composer sniffer-report-csv
```

コード整形
```bash
composer sniffer-rewrite
```

静的解析
```bash
composer static-type-check
```

API仕様書出力
```bash
composer document-generator
```



# Author

* 作成者 omochi1224
