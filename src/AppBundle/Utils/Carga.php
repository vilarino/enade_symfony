<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/03/17
 * Time: 00:27
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Ano;
use AppBundle\Entity\Cidade;
use AppBundle\Entity\Curso;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Exame;
use AppBundle\Entity\Organizacao;
use AppBundle\Entity\Regiao;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function carregarAno(Exame $exame)
    {

        $dimAno = new Ano();
        $dimAno->setId($exame->getAno());
        $dimAno->setAno($exame->getAno());

        $this->em->persist($dimAno);
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
        foreach ($categorias as $categoria) {
            $dimCurso = new Curso();

            $dimCurso->setId($categoria['id']);
            $dimCurso->setNome($categoria['nome']);
            $this->em->persist($dimCurso);
        }
        $this->em->flush();

    }

    public function carregarOrganizacoes($organizacoes)
    {
        foreach ($organizacoes as $organizacao) {
            $dimOrganizacoes = new Organizacao();

            $dimOrganizacoes->setId($organizacao['id']);
            $dimOrganizacoes->setNome($organizacao['nome']);
            $this->em->persist($dimOrganizacoes);
        }
        $this->em->flush();

    }

    public function carregarDados($dados)
    {

        $mysql = new MySql($this->container);

        $mysql->criarTabela('enade', explode(',', $dados[0]));

        $bloco = [];

        $colunas = $dados[0];

        unset($dados[0]);

        $quantidade = count($dados);

        $teste = 0;
        for ($i = 1; $i <= $quantidade; $i++) {
            $bloco[] = $dados[$i];
            if ($i % 5000 == 0 || $i == ($quantidade)) {
                $teste += count($bloco);
                $mysql->inserirDados($colunas, $bloco);
                $bloco = [];
            }
        }
        return true;
    }


}