写経：手を動かしてわかるクリーンアーキテクチャ
====

# 起動

```bash
docker-compose up -d
docker compose run --rm php composer install
```

DBのボリュームもろとも消したいとき

```bash
docker compose down --volume  
```
