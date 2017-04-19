<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/03/17
 * Time: 00:27
 */

namespace AppBundle\Utils;


use Doctrine\ORM\EntityManager;

class Carga
{

    private $entityManager;

    public function __construct()
    {
        /*EntityManager $entityManager
        $this->entityManager = $entityManager;*/
    }

    public function carregarRegioes($regioes)
    {
//        var_dump($regioes); exit;
        // salvar regiões no dw
    }

    public function carregarEstados($estados)
    {
//            var_dump($estados); exit;
    }

    public function carregarCidades($cidades)
    {
        var_dump($cidades);
        exit;
    }

    public function carregarCategorias($categorias)
    {
        /*var_dump($categorias);
        exit;*/
    }

    public function carregarOrganizacoes($organizacoes)
    {
        var_dump($organizacoes);
        exit;
    }

    public function carregarDados($dados)
    {

    }


}