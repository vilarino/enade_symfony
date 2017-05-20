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
 * @ORM\Table(name="enade_dw.DIM_ALUNO")
 * @ORM\Entity
 */
class Aluno
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
     * @ORM\Column(name="idade", type="integer", nullable=false)
     */
    private $idade;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="integer", nullable=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoInscricao", type="string", length=50, nullable=false)
     */
    private $tipoInscricao;

    /**
     * @var string
     *
     * @ORM\Column(name="anoInicioGraduacao", type="integer", nullable=false)
     */
    private $anoInicionGraduacao;

    /**
     * @var string
     *
     * @ORM\Column(name="anoFim2Grau", type="integer", nullable=false)
     */
    private $anoFim2grau;

    /**
     * @var string
     *
     * @ORM\Column(name="notaComponenteEspecifico", type="string", nullable=false)
     */
    private $notaComponenteEspecifico;

    /**
     * @var string
     *
     * @ORM\Column(name="notaGeral", type="string", nullable=false)
     */
    private $notaTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="turnoAula", type="string", nullable=false)
     */
    private $turnoAula;

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
    public function getIdade(): string
    {
        return $this->idade;
    }

    /**
     * @param string $idade
     */
    public function setIdade(string $idade)
    {
        $this->idade = $idade;
    }

    /**
     * @return string
     */
    public function getTipoInscricao(): string
    {
        return $this->tipoInscricao;
    }

    /**
     * @param string $tipoInscricao
     */
    public function setTipoInscricao(string $tipoInscricao)
    {
        $this->tipoInscricao = $tipoInscricao;
    }

    /**
     * @return string
     */
    public function getAnoInicionGraduacao(): string
    {
        return $this->anoInicionGraduacao;
    }

    /**
     * @param string $anoInicionGraduacao
     */
    public function setAnoInicionGraduacao(string $anoInicionGraduacao)
    {
        $this->anoInicionGraduacao = $anoInicionGraduacao;
    }

    /**
     * @return string
     */
    public function getAnoFim2grau(): string
    {
        return $this->anoFim2grau;
    }

    /**
     * @param string $anoFim2grau
     */
    public function setAnoFim2grau(string $anoFim2grau)
    {
        $this->anoFim2grau = $anoFim2grau;
    }

    /**
     * @return string
     */
    public function getNotaComponenteEspecifico(): string
    {
        return $this->notaComponenteEspecifico;
    }

    /**
     * @param string $notaComponenteEspecifico
     */
    public function setNotaComponenteEspecifico(string $notaComponenteEspecifico)
    {
        $this->notaComponenteEspecifico = $notaComponenteEspecifico;
    }

    /**
     * @return string
     */
    public function getNotaTotal(): string
    {
        return $this->notaTotal;
    }

    /**
     * @param string $notaTotal
     */
    public function setNotaTotal(string $notaTotal)
    {
        $this->notaTotal = $notaTotal;
    }

    /**
     * @return string
     */
    public function getSexo(): string
    {
        return $this->sexo;
    }

    /**
     * @param string $sexo
     */
    public function setSexo(string $sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return string
     */
    public function getTurnoAula(): string
    {
        return $this->turnoAula;
    }

    /**
     * @param string $turnoAula
     */
    public function setTurnoAula(string $turnoAula)
    {
        $this->turnoAula = $turnoAula;
    }

}