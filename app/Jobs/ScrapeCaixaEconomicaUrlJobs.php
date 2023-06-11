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
        // Log::info("({$csvRow}) {$this->url}");
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $csvRow = $this->csvRow;

        $data = $this->getData();

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

        $data['num_quartos'] = $this->extractInfo('//span[contains(text(), "Quartos")]');

        $data['insc_imobiliaria'] = $this->extractInfo('//span[contains(text(), "Inscrição imobiliária")]');

        $data['averbacao_leiloes_negativos'] = $this->extractInfo('//span[contains(text(), "Averbação dos leilões negativos")]');

        $data['detalhes'] = $this->extractInfo('//html/body/div[1]/form/div[1]/div/div[3]/p[2]');

        $endereco = $this->crawlerInstance->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[1]')
            ->html();
        $data['endereco'] = explode('<br>', $endereco)[1];

        $data['informacoes'] = $this->crawlerInstance->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[3]')
            ->each(function ($node) {
                $linhas = explode('<br>', $node->html());
                $dados = [];

                foreach ($linhas as $linha) {
                    if (!trim($linha)) {
                        continue;
                    }
                    $dados[] = trim(strip_tags($linha), "&nbsp; \t\n\r\0\x0B");
                }

                return $dados;
            });
        $data['tipo_imovel'] = $this->extractInfo('//span[contains(text(), "Tipo de imóvel")]');

        return $data;
    }

    protected function extractInfo($xpath)
    {
        try {
            $data = $this->crawlerInstance->filterXPath($xpath);
            return trim(explode(':', $data->text())[1]);
        } catch (\Throwable $th) {
            Log::critical("Scrape Error notFound:{$xpath}");
            return false;
        }
    }
}
