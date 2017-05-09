<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 19/04/17
 * Time: 21:31
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exame
 *
 * @ORM\Table(name="enade_dw.DIM_ANO")
 * @ORM\Entity
 */
class Ano
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
     * @ORM\Column(name="ano", type="string", length=4, nullable=true)
     */
    private $ano;

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
    public function getAno(): string
    {
        return $this->ano;
    }

    /**
     * @param string $ano
     */
    public function setAno(string $ano)
    {
        $this->ano = $ano;
    }

}