<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 26/04/17
 * Time: 21:36
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="enade_dw.FATO_DESEMPENHO")
 * @ORM\Entity
 */
class Desempenho
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
     * @var integer
     *
     * @ORM\Column(name="id_dim_regiao", type="integer", nullable=false)
     */
    private $id_dim_regiao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_estado", type="integer", nullable=false)
     */
    private $id_dim_estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_municipio", type="integer", nullable=false)
     */
    private $id_dim_municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_curso", type="integer", nullable=false)
     */
    private $id_dim_curso;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_organizacao", type="integer", nullable=false)
     */
    private $id_dim_organizacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_ano", type="integer", nullable=false)
     */
    private $id_dim_ano;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dim_tipoinstituicao", type="integer", nullable=false)
     */
    private $id_dim_tipoinstituicao;

    /**
     * One Product has One Shipping.
     * @ORM\OneToOne(targetEntity="Aluno")
     * @ORM\JoinColumn(name="id_dim_aluno", referencedColumnName="id")
     */
    private $id_dim_aluno;

    /**
     * @var integer
     *
     * @ORM\Column(name="notaGeral", type="integer", nullable=false)
     */
    private $notaTotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="notaComponenteEspecifico", type="integer", nullable=false)
     */
    private $notaComponenteEspecifico;

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
     * @return int
     */
    public function getIdDimRegiao(): int
    {
        return $this->id_dim_regiao;
    }

    /**
     * @param int $id_dim_regiao
     */
    public function setIdDimRegiao(int $id_dim_regiao)
    {
        $this->id_dim_regiao = $id_dim_regiao;
    }

    /**
     * @return int
     */
    public function getIdDimEstado(): int
    {
        return $this->id_dim_estado;
    }

    /**
     * @param int $id_dim_estado
     */
    public function setIdDimEstado(int $id_dim_estado)
    {
        $this->id_dim_estado = $id_dim_estado;
    }

    /**
     * @return int
     */
    public function getIdDimMunicipio(): int
    {
        return $this->id_dim_municipio;
    }

    /**
     * @param int $id_dim_municipio
     */
    public function setIdDimMunicipio(int $id_dim_municipio)
    {
        $this->id_dim_municipio = $id_dim_municipio;
    }

    /**
     * @return int
     */
    public function getIdDimCurso(): int
    {
        return $this->id_dim_curso;
    }

    /**
     * @param int $id_dim_curso
     */
    public function setIdDimCurso(int $id_dim_curso)
    {
        $this->id_dim_curso = $id_dim_curso;
    }

    /**
     * @return int
     */
    public function getIdDimOrganizacao(): int
    {
        return $this->id_dim_organizacao;
    }

    /**
     * @param int $id_dim_organizacao
     */
    public function setIdDimOrganizacao(int $id_dim_organizacao)
    {
        $this->id_dim_organizacao = $id_dim_organizacao;
    }

    /**
     * @return int
     */
    public function getIdDimAno(): int
    {
        return $this->id_dim_ano;
    }

    /**
     * @param int $id_dim_ano
     */
    public function setIdDimAno(int $id_dim_ano)
    {
        $this->id_dim_ano = $id_dim_ano;
    }

    /**
     * @return mixed
     */
    public function getIdDimAluno()
    {
        return $this->id_dim_aluno;
    }

    /**
     * @param mixed $id_dim_aluno
     */
    public function setIdDimAluno($id_dim_aluno)
    {
        $this->id_dim_aluno = $id_dim_aluno;
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
     * @return mixed
     */
    public function getIdDimTipoinstituicao()
    {
        return $this->id_dim_tipoinstituicao;
    }

    /**
     * @param mixed $id_dim_tipoinstituicao
     */
    public function setIdDimTipoinstituicao($id_dim_tipoinstituicao)
    {
        $this->id_dim_tipoinstituicao = $id_dim_tipoinstituicao;
    }

}