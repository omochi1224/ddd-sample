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
docker-compose up -d
docker-compose exec php composer install -vvv
docker-compose exec php php artisan key:generate
```

新規機能(パッケージ)追加
```bash
docker-compose exec php php artisan make:feature
```
パッケージ追加時はcomposer.jsonのautoloadにpsr-4の記述で追加してください。<br>
例
```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Basic\\": "packages/Basic",
            "Auth\\": "packages/Auth",
            "AddPackage\\": "packages/AddPackage"
        }
    }
}
```

すべてのテスト実行
```bash
docker-compose exec php composer test
```

コードが整形リスト
```bash
docker-compose exec php composer sniffer
```

コードが整形リストCSV
```bash
docker-compose exec php composer sniffer-report-csv
```

コード整形
```bash
docker-compose exec php composer sniffer-rewrite
```

静的解析
```bash
docker-compose exec php composer static-type-check
```

API仕様書出力
```bash
docker-compose exec php composer document-generator
```



# Author

* 作成者 omochi1224
