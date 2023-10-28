# Invest Cubo

## Comando para rodar os jobs

$ Rodar\ todos\ os\ estados $

```php
App\Jobs\ManageCaixaImovelFilesJob::dispatchSync();
```

$ Rodar\ do\ estado\ do\ Amazonas $

```php
\App\Jobs\DownloadCSVCaixaJobs::dispatchSync(\App\Models\EstadosBrasileiro::where('uf', 'rs')->first());
```

$ Rodar\ raspagem\ de\ um\ registro $

```php
\App\Jobs\ScrapeCaixaEconomicaUrlJobs::dispatchSync(\App\Models\CaixaImovel::find(4));
```

$ Rodar\ atualização\ de\ um\ registro $

```php
\App\Jobs\UpdateImoveisFromCaixaJobs::dispatchSync(\App\Models\CaixaImovel::find(4));
```

$ uso\ de\ geocoder$

```php
$geocoder = app('geocoder');
$coordinates = $geocoder->getCoordinates('Residencial Jardins da Cidade');
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
