<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/03/17
 * Time: 00:24
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Arquivo;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Extracao
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->diretorioArquivos = $this->container->get('kernel')->getRootDir() . '/../web/files/';
    }

    public function extrairRegioes(Arquivo $arquivoDicionario)
    {
        $regioes = [];
        // Carregando o arquivo
        $objPHPExcel = \PHPExcel_IOFactory::load($this->diretorioArquivos . $arquivoDicionario->getNome());

        // Pegando a célula com as informações
        $cell = $objPHPExcel->getActiveSheet()->getCell('F11');

        $str = $cell->getValue();

        $regioesComId = explode(PHP_EOL, $str);

        foreach ($regioesComId as $regiao) {
            $regiaoComIdSeparado = explode('=', $regiao);

            $regioes[] = [
                'id' => trim($regiaoComIdSeparado[0]),
                'nome' => trim($regiaoComIdSeparado[1])
            ];
        }

        return $regioes;
    }

    public function extrairEstados(Arquivo $arquivoDicionario)
    {
        $estados = [];

        $objPHPExcel = \PHPExcel_IOFactory::load($this->diretorioArquivos . $arquivoDicionario->getNome());

        $cell = $objPHPExcel->getActiveSheet()->getCell('F10');

        $str = $cell->getValue();

        $doisEstadosPorLinha = explode(PHP_EOL, $str);

        foreach ($doisEstadosPorLinha as $linha) {
            $estadosSeparados = array_filter(explode('  ', $linha));

            foreach ($estadosSeparados as $estadosComNumero) {
                $estado = explode('=', $estadosComNumero);
                $estados[] = [
                    'id' => trim($estado[0]),
                    'nome' => trim($estado[1])
                ];
            }
        }
        return $estados;
    }

    public function extrairCidades(Arquivo $arquivoDicionario)
    {
        $cidades = [];

        $objPHPExcel = \PHPExcel_IOFactory::load($this->container->get('kernel')->getRootDir() . '/../web/files/' . $arquivoDicionario->getNome());
        $objPHPExcel->setActiveSheetIndex(1);

        $fim = false;
        $i = 5;

        while (!$fim) {
            $arrayCelulas = $objPHPExcel->getActiveSheet()->rangeToArray('B' . $i . ':D' . $i);
            if (isset($arrayCelulas[0]) && is_null($arrayCelulas[0][0])) {
                $fim = true;
            } else {

                $cidade = $arrayCelulas[0];

                $cidades[] = [
                    'id' => $cidade[0],
                    'nome' => $cidade[1],
                    'sigla_estado' => $cidade [2],
                ];


                $i++;
            }

        }


        return $cidades;
    }

    public function extrairCategorias(Arquivo $arquivoDicionario)
    {
        $categorias = [];

        // Carregando o arquivo
        $objPHPExcel = \PHPExcel_IOFactory::load($this->diretorioArquivos . $arquivoDicionario->getNome());

        // Pegando a célula com as informações
        $cell = $objPHPExcel->getActiveSheet()->getCell('F5');

        $str = $cell->getValue();
        $categoriaComNumero = explode(PHP_EOL, $str);
        foreach ($categoriaComNumero as $categoria) {
            $categoriaSeparadasDoNumero = explode('=', $categoria);
            $categorias[] = [
                'id' => trim($categoriaSeparadasDoNumero[0]),
                'nome' => trim($categoriaSeparadasDoNumero[1])
            ];
        }

        return $categorias;
    }

    public function extrairOrganizacoes($arquivoDicionario)
    {
        $organizacoes = [];

        // Carregando o arquivo
        $objPHPExcel = \PHPExcel_IOFactory::load($this->diretorioArquivos . $arquivoDicionario->getNome());

        // Pegando a célula com as informações
        $cell = $objPHPExcel->getActiveSheet()->getCell('F8');

        $str = $cell->getValue();
        $organizacoesComNumero = explode(PHP_EOL, $str);
        foreach ($organizacoesComNumero as $organizacao) {
            $organizacaoSeparadaDoNumero = explode('=', $organizacao);
            $organizacoes[] = [
                'id' => trim($organizacaoSeparadaDoNumero[0]),
                'nome' => trim($organizacaoSeparadaDoNumero[1])
            ];
        }

        return $organizacoes;
    }

    public function extrairDados(Arquivo $arquivoDados)
    {
        $dados = [];

        return $dados;
    }

}