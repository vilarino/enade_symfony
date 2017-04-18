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
        // Carregando o arquivo
        $objPHPExcel = \PHPExcel_IOFactory::load($this->diretorioArquivos . $arquivoDicionario->getNome());

        // Pegando a célula com as informações
        $cell = $objPHPExcel->getActiveSheet()->getCell('F11');

        $str = $cell->getValue();

        return explode(PHP_EOL, $str);
    }

    public function extrairEstados(Arquivo $arquivoDicionario)
    {
        $estados = [];

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
            if (isset($arrayCells[0]) && is_null($arrayCells[0][0])) {
                $fim = true;
            } else {
                $cidade = $arrayCelulas[0];

                var_dump($arrayCelulas[0]);
                exit;
                //                $qb->insert('municipio')->values(
//                    array(
//                        'id' => $city[0],
//                        'nome' => utf8_decode("\"" . $city[1] . "\""),
//                        'sigla_estado' => utf8_decode("\"" . $city[2] . "\""),
//                        'nome_coluna' => "\"co_munic_curso\""
//                    )
//                );

                $i++;
            }

        }


        return $cidades;
    }

    public function extrairCategorias($aarquivoDicionario)
    {
        $categorias = [];

        return $categorias;
    }

    public function extrairOrganizacoes($arquivoDicionario)
    {
        $organizacoes = [];

        return $organizacoes;

    }

    public function extrairDados($arquivoDados)
    {
        $dados = [];

        return $dados;
    }

}