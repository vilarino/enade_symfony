<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/03/17
 * Time: 00:27
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Cidade;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Regiao;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Carga
{

    private $container;
    private $em;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function carregarRegioes($regioes)
    {
        foreach ($regioes as $regiao) {
            $dimRegiao = new Regiao();

            $dimRegiao->setId($regiao['id']);
            $dimRegiao->setNome($regiao['nome']);

            $this->em->persist($dimRegiao);
        }

        $this->em->flush();
    }

    public function carregarEstados($estados)
    {

        foreach ($estados as $estado) {
            $dimEstado = new Estado();

            $dimEstado->setId($estado['id']);
            $dimEstado->setNome($estado['nome']);

            $this->em->persist($dimEstado);
        }

        $this->em->flush();
    }

    public function carregarCidades($cidades)
    {
        foreach ($cidades as $cidade) {
            $dimCidade = new Cidade();

            $dimCidade->setId($cidade['id']);
            $dimCidade->setNome($cidade['nome']);
            $dimCidade->setSigaEstado($cidade['sigla_estado']);

            $this->em->persist($dimCidade);
        }
        $this->em->flush();

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