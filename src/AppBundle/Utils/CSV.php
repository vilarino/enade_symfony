<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/03/17
 * Time: 00:11
 */

namespace AppBundle\Utils;


class CSV
{
    private $caminhoArquvio;
    private $arquivo;
    private $colunas;

    public function __construct($caminhoArquivo)
    {
        $this->caminhoArquvio = $caminhoArquivo;
        $this->colunas = array();
        $this->arquivo = null;
    }

    /**
     * Retorna um array da primeira linha de um arquivo csv (colunas)
     * @return array
     * @throws \Exception
     */
    public function getColunas()
    {

        if (!empty($this->colunas)) {
            return $this->colunas;
        }

        $this->abrirArquivo();

        if ($lineColumns = fgetcsv($this->arquivo)) {

            $this->colunas = explode(";", $lineColumns[0]); // está pegando $lineColumns[0] por que as colunas estão dentro de um array

            return $this->colunas;
        }

        throw new \Exception("Falha ao buscar colunas!");
    }

    public function abrirArquivo()
    {
        if (!($this->arquivo = fopen($this->caminhoArquvio, "r"))) {
            throw new \Exception("Falha ao tentar abrir aquivo!");
        }
    }

    /**
     * Retorna array com as linhas também no formato de array
     */
    public function getDados()
    {
        if (is_null($this->arquivo)) {
            $this->abrirArquivo();
        }

        $linhas = [];
        while ($linha = $this->proximaLinha()) {
            $linhas[] = implode(',', $linha);
        }

        $this->fecharArquivo();
        return $linhas;
    }

    private function proximaLinha()
    {
        if (feof($this->arquivo)) {
            return false;
        }

        $line = fgetcsv($this->arquivo);

        if (!isset($line[0])) {
            return false;
        }

        $arrayLine = explode(";", $line[0]);

        $this->replaceValues($arrayLine);

        return $arrayLine;
    }

    private function replaceValues(&$arrayLine)
    {
        foreach ($arrayLine as &$item) {
            if (empty($item) and $item !== 0 and $item !== "0") {
                $item = 'NULL';
            }
        }
    }

    private function fecharArquivo()
    {
        fclose($this->arquivo);
    }
}