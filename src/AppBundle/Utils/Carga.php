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

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function carregarRegioes($regioes)
    {
        // salvar regiões no dw
    }

    public function carregarEstados($estados)
    {

    }

    public function carregarCidades($cidades)
    {

    }

    public function carregarCategorias($categorias)
    {

    }

    public function carregarOrganizacoes($organizacoes)
    {

    }

    public function carregarDados($dados)
    {

    }


}