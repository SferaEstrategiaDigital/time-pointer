<?php

namespace App\Jobs;

use App\Models\CaixaImovel;
use App\Models\CaixaImovelsItem;
use GuzzleHttp\Client;
use App\Models\PropertyType;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ScrapeCaixaEconomicaUrlJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url = "https://venda-imoveis.caixa.gov.br/sistema/detalhe-imovel.asp?hdnOrigem=index&hdnimovel=%s";
    protected $crawlerInstance;
    protected $delString = "O imóvel que você procura não está mais disponível para venda";

    public function __construct(protected CaixaImovel $csvRow)
    {
        $this->csvRow = $csvRow;
        $this->url = sprintf($this->url, $this->csvRow->num_imovel);
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        Log::info("{$this->url}");
        $csvRow = $this->csvRow;

        $client = new Client();

        try {
            $response = $client->request('GET', $this->url);
        } catch (\Throwable $th) {
            Log::critical("Scrape Error connection: {$csvRow->id}");
            return false;
        }

        /* VERIFICA SE O STATUS DA RESPOSTA É 200 OU 301 */
        if (!in_array($response->getStatusCode(), ['200', '301'])) {
            return false;
        }
        $this->crawlerInstance = new Crawler((string)$response->getBody());

        $deleted = $this->crawlerInstance->filterXPath('//html/body/div[1]/form/div/div');

        if ($deleted->count() && strpos($deleted->text(), "$this->delString") > -1) {
            Log::critical("Scrape Error recordDeleted: {$csvRow->id}");
            return false;
        }

        $data = $this->getData();

        foreach ($data as $item) {
            $split = explode(":", $item, 2);
            $caixaItem = CaixaImovelsItem::firstOrCreate([
                'item' => trim($split[0], " \t\n\r\0\x0B)(")
            ]);

            $this->csvRow->items()->attach($caixaItem, [
                'value' => trim($split[1], " \t\n\r\0\x0B)("),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        try {
            $csvRow->update([
                'scrapped_at' => now(),
            ]);
            UpdateImoveisFromCaixaJobs::dispatchSync($csvRow);
        } catch (\Throwable $th) {
            Log::critical("Scrape Error update:{$csvRow->id};{$th->getMessage()};" . json_encode($data));
            Log::critical(json_encode($th->getTrace()));
        }

        return true;
    }

    protected function getData()
    {

        $data = [];
        // $valorVenda = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[2]');
        // $valorAvaliacao = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[1]');
        // $num_imovel = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[3]/strong');

        $endereco = $this->crawlerInstance->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[1]')
            ->html();
        // Add "Endereço:" no início pra seguir o padrão
        $data[] = "Endereço:" . explode('<br>', $endereco)[1];

        // BUSCA PELO COMENTÁRIO ONDE DEFINE SE O IMÓVEL É OU NÃO OCUPADO
        $ocupacao = $this->crawlerInstance->filterXPath('//comment()')->each(function (Crawler $node, $i) {
            if (strpos($node->text(), 'span>') !== false) {
                return html_entity_decode(strip_tags("<{$node->text()}"));
            }
        });

        $ocupacao = array_filter($ocupacao);
        $data[] = end($ocupacao);

        $spans = $this->crawlerInstance->filterXpath('//span')
            ->each(function ($node) {
                if (strpos($node->text(), ':') || strpos($node->text(), '=')) {
                    return str_replace(" = ", ":", $node->text());
                }
            });

        // Remove os nulos
        $spans = array_filter($spans);

        $infos = $this->crawlerInstance->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[3]');
        $infos = explode('<br>', $infos->html());
        $infos = array_filter($infos);
        $infos = array_map(fn ($info) => "Forma de pagamento:" . trim(strip_tags($info), " \t\n\r\0\x0B&nbsp;"), $infos);

        // $data['num_quartos'] = $this->extractInfo($spans,"Quartos: ", 0);
        // $data['insc_imobiliaria'] = $this->extractInfo($spans, "Inscrição imobiliária: ", 0);
        // $data['averbacao_leiloes_negativos'] = $this->extractInfo($spans, "Averbação dos leilões negativos: ", 0);
        // $data['tipo_imovel'] = $this->extractInfo($spans, "Tipo de imóvel: ", 0);

        $destaque = $this->crawlerInstance->filterXPath('//html/body/div[1]/form/div[1]/div/div[3]/p[2]');

        $data[] = $destaque->count() ? $destaque->text() : "";

        return array_merge($data, $spans, $infos);
    }

    protected function extractInfo($spans, $findFor, $default = false)
    {
        $found = array_filter($spans, fn ($span) => strpos($span, $findFor) > -1);
        if ($found) {
            return trim(explode($findFor, end($found))[1]);
        } else {
            return $default;
        }
    }
}
