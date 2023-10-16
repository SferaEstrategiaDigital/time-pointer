# Invest Cubo

### Comando para rodar os jobs

```php
App\Jobs\ManageCaixaImovelFilesJob::dispatchSync();
```

```php
\App\Jobs\DownloadCSVCaixaJobs::dispatchSync(\App\Models\EstadosBrasileiro::find(4));
```

```php
\App\Jobs\ScrapeCaixaEconomicaUrlJobs::dispatchSync(\App\Models\CaixaImovel::find(4));
```

### SQL para testar se tem duplicados em IMOVELS

```sql
WITH Duplicados AS (
    SELECT NUM_IMOVEL
    FROM IMOVELS
    GROUP BY NUM_IMOVEL
    HAVING COUNT(NUM_IMOVEL) > 1
)
SELECT c.*
FROM IMOVELS c
JOIN Duplicados d ON c.NUM_IMOVEL = d.NUM_IMOVEL
ORDER BY c.NUM_IMOVEL;

```
