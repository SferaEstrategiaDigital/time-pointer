<?php

namespace App\Jobs;

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

    public function __construct(protected $csvRow)
    {
        $this->csvRow = $csvRow;
        $this->url = sprintf($this->url, $this->csvRow->num_imovel);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $csvRow = $this->csvRow;

        $client = new Client();

        try {
            $response = $client->request('GET', $this->url);
        } catch (\Throwable $th) {
            Log::critical("Scrape Error: {$csvRow->id}");
            die;
        }

        /* VERIFICA SE O STATUS DA RESPOSTA É 200 OU 301 */
        if (!in_array($response->getStatusCode(), ['200', '301'])) {
            die;
        }
        $crawler = new Crawler((string)$response->getBody());

        $informacoes = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[3]')
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
        // $valorVenda = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[2]');
        // $valorAvaliacao = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[2]/h4[1]');
        // $num_imovel = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[3]/strong');
        $num_quartos = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[2]/strong');
        $insc_imobiliaria = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[7]/strong');
        $averbacao_leiloes_negativos = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[8]/strong');

        $detalhes = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[3]/p[2]');
        $endereco = $crawler->filterXpath('//html/body/div[1]/form/div[1]/div/div[3]/p[1]')
            ->html();
        $endereco = explode('<br>', $endereco)[1];

        $tipoImovel = $crawler->filterXPath('//html/body/div[1]/form/div[1]/div/div[2]/div[1]/p/span[1]/strong');
        $tipoImovel = PropertyType::firstOrCreate([
            'type' => $tipoImovel->text()
        ]);

        $csvRow->update([
            'endereco' => $endereco,
            'insc_imobiliaria' => $insc_imobiliaria->text(),
            'num_quartos' => $num_quartos->text(),
            'averbacao_leiloes_negativos' => $averbacao_leiloes_negativos->text(),
            'property_type_id' => $tipoImovel->id,
            'detalhes' => $detalhes->text(),
            'scrapped_at' => now()
        ]);
    }
}
