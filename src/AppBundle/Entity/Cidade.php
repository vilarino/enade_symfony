<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 19/04/17
 * Time: 23:47
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="enade_dw.DIM_MUNICIPIO")
 * @ORM\Entity
 */
class Cidade
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla_estado", type="string", length=255, nullable=true)
     */
    private $sigaEstado;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getSigaEstado(): string
    {
        return $this->sigaEstado;
    }

    /**
     * @param string $sigaEstado
     */
    public function setSigaEstado(string $sigaEstado)
    {
        $this->sigaEstado = $sigaEstado;
    }

}