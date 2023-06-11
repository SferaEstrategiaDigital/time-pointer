<?php

namespace App\Jobs;

use App\Models\CaixaCsv;
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

    public function __construct(protected CaixaCsv $csvRow)
    {
        $this->csvRow = $csvRow;
        $this->url = sprintf($this->url, $this->csvRow->num_imovel);
        Log::info("{$this->url}");
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $csvRow = $this->csvRow;

        $data = $this->getData();

        dd($data);

        $tipoImovel = PropertyType::firstOrCreate([
            'type' => $data['tipo_imovel']
        ]);

        try {
            $csvRow->update([
                'endereco' => $data['endereco'],
                'insc_imobiliaria' => $data['insc_imobiliaria'],
                'num_quartos' => $data['num_quartos'],
                'averbacao_leiloes_negativos' => $data['averbacao_leiloes_negativos'],
                'property_type_id' => $tipoImovel->id,
                'detalhes' => $data['detalhes'],
                'scrapped_at' => now(),
            ]);
        } catch (\Throwable $th) {
            Log::critical("Scrape Error update:{$csvRow->id};{$th->getMessage()};" . json_encode($data));
            Log::critical(json_encode($th->getTrace()));
        }

        return true;
    }

    protected function getData()
    {
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
            return;
        }
        $this->crawlerInstance = new Crawler((string)$response->getBody());

        $data = [];
        // $valorVenda = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[2]');
        // $valorAvaliacao = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[1]');
        // $num_imovel = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[3]/strong');

        $endereco = $this->crawlerInstance->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[1]')
            ->html();
        $data['endereco'] = explode('<br>', $endereco)[1];

        // BUSCA PELO COMENTÁRIO ONDE DEFINE SE O IMÓVEL É OU NÃO OCUPADO
        $ocupacao = $this->crawlerInstance->filterXPath('//comment()')->each(function (Crawler $node, $i) {
            if (strpos($node->text(), 'span>') !== false) {
                preg_match('/<strong>(.*?)<\/strong>/', $node->text(), $matches);
                if(isset($matches[1])){
                    return $matches[1];
                }
            }
        });

        $ocupacao = array_filter($ocupacao);
        $data['ocupacao'] = end($ocupacao);

        $spans = $this->crawlerInstance->filterXpath('//span')
            ->each(function ($node) {
                if(strpos($node->text(), ':') || strpos($node->text(), '=')){
                    return $node->text();
                }
            });
        // Remove os nulos
        $spans = array_filter($spans);

        dd($spans);

        $data['num_quartos'] = $this->extractInfo($spans,"Quartos: ", 0);
        $data['insc_imobiliaria'] = $this->extractInfo($spans, "Inscrição imobiliária: ", 0);
        $data['averbacao_leiloes_negativos'] = $this->extractInfo($spans, "Averbação dos leilões negativos: ", 0);
        $data['tipo_imovel'] = $this->extractInfo($spans, "Tipo de imóvel: ", 0);

        $destaque = $this->crawlerInstance->filterXPath('//html/body/div[1]/form/div[1]/div/div[3]/p[2]');

        $data['detalhes'] = $destaque->count() ? (strpos($destaque->text(), "Descrição:") > -1 ? trim(explode("Descrição:", $destaque->text())[1]) : "") : "";

        return $data;
    }

    protected function extractInfo($spans, $findFor, $default = false)
    {
        $found = array_filter($spans, fn($span) => strpos($span,$findFor) > -1);
        if($found){
            return trim(explode($findFor, end($found))[1]);
        }else{
            return $default;
        }
    }
}
