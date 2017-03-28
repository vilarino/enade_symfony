<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Arquivo
 *
 * @ORM\Table(name="arquivo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArquivoRepository")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Arquivo
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
     * @ORM\Column(name="nome_arquivo", type="string", length=255)
     */
    private $nomeArquivo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="files", fileNameProperty="nome")
     *
     * @var File
     */
    private $arquivoVich;


    /**
     * @var string
     *
     * @ORM\Column(name="mime_type_arquivo", type="string", length=255)
     */
    private $mimeTypeArquivo;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Exame", inversedBy="arquivos")
     * @ORM\JoinColumn(name="exame_id", referencedColumnName="id")
     */
    private $exame;


    /**
     * @ORM\ManyToOne(targetEntity="Tipo", inversedBy="arquivos")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    private $tipo;

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
     * Set nomeArquivo
     *
     * @param string $nomeArquivo
     *
     * @return Arquivo
     */
    public function setNomeArquivo($nomeArquivo)
    {
        $this->nomeArquivo = $nomeArquivo;

        return $this;
    }

    /**
     * Get nomeArquivo
     *
     * @return string
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * Set mimeTypeArquivo
     *
     * @param string $mimeTypeArquivo
     *
     * @return Arquivo
     */
    public function setMimeTypeArquivo($mimeTypeArquivo)
    {
        $this->mimeTypeArquivo = $mimeTypeArquivo;

        return $this;
    }

    /**
     * Get mimeTypeArquivo
     *
     * @return string
     */
    public function getMimeTypeArquivo()
    {
        return $this->mimeTypeArquivo;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Arquivo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return File
     */
    public function getArquivoVich()
    {
        return $this->arquivoVich;
    }

    /**
     * @param File $arquivoVich
     */
    public function setArquivoVich($arquivoVich)
    {
        $this->arquivoVich = $arquivoVich;
    }

    /**
     * @return mixed
     */
    public function getExame()
    {
        return $this->exame;
    }

    /**
     * @param mixed $exame
     */
    public function setExame($exame)
    {
        $this->exame = $exame;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

}

