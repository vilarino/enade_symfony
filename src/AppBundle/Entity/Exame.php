<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Exame
 *
 * @ORM\Table(name="exame")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExameRepository")
 */
class Exame
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity="Arquivo", mappedBy="exame", cascade={"all"})
     */
    private $arquivos;

    /**
     * @var int
     *
     * @ORM\Column(name="ano", type="integer")
     */
    private $ano;

    public function __construct()
    {
        $this->arquivos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Exame
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set ano
     *
     * @param integer $ano
     *
     * @return Exame
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get ano
     *
     * @return int
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @return mixed
     */
    public function getArquivos()
    {
        return $this->arquivos;
    }

    /**
     * @param Arquivo $arquivo
     */
    public function addArquivo(Arquivo $arquivo)
    {
        $this->arquivos->add($arquivo);
    }
}

