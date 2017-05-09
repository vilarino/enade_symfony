<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 02/05/17
 * Time: 22:04
 */

namespace AppBundle\Utils;

use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class MySql
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Cria uma tabela no banco de dados de acordo com os parametros
     *
     * @param $nome nome da tabela
     * @param array $columns as colunas do arquivo CSV
     * @return bool
     */
    public function criarTabela($nome, $colunas = array())
    {
        if ($this->tabelaExiste($nome)) {
            $this->exec("DROP TABLE {$nome}");
        }

        $colunasComando = $this->getComandoColunas($colunas);

        $sql = " CREATE TABLE {$nome} ( ";

        $sqlArray = [];
        foreach ($colunasComando as $coluna) {
            $sqlArray[] = str_replace("\"", "", $coluna['name'] . " " . $coluna['command']);
        }

        $sql .= implode(", ", $sqlArray) . " ) ";

        $resposta = $this->exec($sql);

        return !empty($resposta);
    }

    private function getComandoColunas($colunas)
    {

        $colunasComando = [];

        $colunasComando[] = [
            'name' => 'id',
            'command' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY'
        ];

        foreach ($colunas as $coluna) {
            $colunasComando[] = [
                'name' => $coluna,
                'command' => 'VARCHAR(100) NULL'
            ];
        }

        return $colunasComando;
    }

    private function tabelaExiste($nome)
    {

        $sql = "SHOW TABLES WHERE Tables_in_enade = '{$nome}'";

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('Tables_in_enade', 'Tables_in_enade');

        $query = $this->container->get('doctrine')->getEntityManager()->createNativeQuery($sql, $rsm);


        $tabelas = $query->getArrayResult();

        return !empty($tabelas);
    }

    private function exec($sql)
    {
        $this->container->get('doctrine')->getEntityManager()->getConnection()->executeQuery($sql);
        return true;
    }

    /**
     * @param $colunas
     * @param $dados
     * @return bool
     */
    public function inserirDados($colunas, $dados)
    {
        $sql = $this->createQuery($colunas, $dados);

        return $this->exec($sql);
    }

    private function createQuery($colunas, $dados)
    {
        $strColumns = str_replace("\"", "", $colunas);

        $sql = "";

        foreach ($dados as $item) {
            $sql .= "INSERT INTO enade ({$strColumns}) VALUES ({$item});";
        }

        return $sql;
    }
}