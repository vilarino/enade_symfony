<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 19/04/17
 * Time: 22:22
 */

namespace AppBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class Descarga
{
    private $container;
    private $em;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function descargaRegioes()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete('AppBundle\Entity\Regiao', 'a')
            ->getQuery()->getResult();
    }

    public function descargaEstados()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete('AppBundle\Entity\Estado', 'a')
            ->getQuery()->getResult();
    }

    public function descargaCidades()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete('AppBundle\Entity\Cidade', 'a')
            ->getQuery()->getResult();
    }
}