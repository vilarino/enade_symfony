<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Aluno;
use AppBundle\Entity\Desempenho;
use AppBundle\Utils\Tipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ETLController
 *
 * @Route("etl")
 */
class ETLController extends Controller
{
    /**
     * @Route("/", name="executar")
     * @Method("GET")
     */
    public function processoAction()
    {
        set_time_limit(60000 * 10);

        try {
            $examesNaoCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => false]);

            /*$tipo = $this->getDoctrine()->getRepository('AppBundle:Tipo')->find(Tipo::DICIONARIO);*/

            foreach ($examesNaoCarregados as $exame) {

                $arquivoDicionario = $exame->getArquivos()->filter(function ($arquivo) {
                    return $arquivo->getTipo()->getId() === Tipo::DICIONARIO;
                });

                $this->get('carga')->carregarAno($exame);

                $regioes = $this->get('extracao')->extrairRegioes($arquivoDicionario->first());
                $this->get('carga')->carregarRegioes($regioes);

                $estados = $this->get('extracao')->extrairEstados($arquivoDicionario->first());
                $this->get('carga')->carregarEstados($estados);

                $cidades = $this->get('extracao')->extrairCidades($arquivoDicionario->first());
                $this->get('carga')->carregarCidades($cidades);

                $categorias = $this->get('extracao')->extrairCategorias($arquivoDicionario->first());
                $this->get('carga')->carregarCategorias($categorias);

                $organizacoes = $this->get('extracao')->extrairOrganizacoes($arquivoDicionario->first());
                $this->get('carga')->carregarOrganizacoes($organizacoes);

                $arquivoDados = $exame->getArquivos()->filter(function ($arquivo) {
                    return $arquivo->getTipo()->getId() === Tipo::DADOS;
                });

                $dados = $this->get('extracao')->extrairDados($arquivoDados->first());

                $this->get('carga')->carregarDados($dados);

                $this->addFlash('success', 'Foram carregados ' . count($dados) . ' para o exame de ' . $exame->getAno());
            }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirect($this->generateUrl('etl_importar'));

        } catch (\Exception $exception) {
//            echo($exception->getTraceAsString());
            var_dump($exception->getMessage());
            exit;
        }

    }

    /**
     * @Route("/limpar", name="etl_limpar")
     * @Method("GET")
     */
    public function limparAction()
    {
        set_time_limit(6000 * 10);

        try {
            $this->get('descarga')->descargaDesempenho();
            $this->get('descarga')->descargaRegioes();
            $this->get('descarga')->descargaEstados();
            $this->get('descarga')->descargaCidades();
            $this->get('descarga')->descargaCursos();
            $this->get('descarga')->descargaOrganizacoes();
            $this->get('descarga')->descargaAnos();
            $this->get('descarga')->descargaAluno();

            $this->addFlash('success', 'Registros removidos com sucesso');

            $examesNaoCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => true]);
            foreach ($examesNaoCarregados as $exame) {
                $exame->setCarregado(false);

                $this->getDoctrine()->getManager()->persist($exame);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('exame_index'));
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit;
        }

    }

    /**
     * @Route("/importar", name="etl_importar")
     * @Method("GET")
     */
    public function importarTabelaFato()
    {
        set_time_limit(60000 * 10);
        try {

            $examesCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => true]);

            foreach ($examesCarregados as $exame) {

                $parar = false;
                $start = 0;
                $limit = 5000;

                while (!$parar) {
                    $sql = "select * from enade where tp_pres = 555 and tp_pr_ger = 555 and nu_ano = " . $exame->getAno() . " LIMIT {$start} ,{$limit} ";

                    $con = $this->getDoctrine()->getEntityManager()->getConnection();
                    $stmt = $con->prepare($sql);

                    $stmt->execute();
                    $dados = $stmt->fetchAll();

                    if (empty($dados)) {
                        $parar = true;
                        continue;
                    }


                    foreach ($dados as $dado) {

                        $dimAluno = new Aluno();
                        $dimAluno->setId($dado['id']);
                        $dimAluno->setSexo($dado['tp_sexo']);
                        $dimAluno->setIdade($dado['nu_idade']);
                        $dimAluno->setTipoInscricao($dado['tp_inscricao'] === '0' ? 'Concluinte' : 'Ingressante');
                        $dimAluno->setAnoInicionGraduacao($dado['ano_in_grad']);
                        $dimAluno->setAnoFim2grau($dado['ano_fim_2g']);
                        $dimAluno->setNotaComponenteEspecifico(is_null($dado['nt_ce']) ? 0 : $dado['nt_ce']);
                        $dimAluno->setNotaTotal(is_null($dado['nt_ger']) ? 0 : $dado['nt_ger']);
                        $dimAluno->setTurnoAula($this->getTurno($dado));

                        $this->getDoctrine()->getManager()->persist($dimAluno);

                        $desempenho = new Desempenho();
                        $desempenho->setIdDimRegiao($dado['co_regiao_curso']);
                        $desempenho->setIdDimEstado($dado['co_uf_curso']);
                        $desempenho->setIdDimMunicipio($dado['co_munic_curso']);
                        $desempenho->setIdDimCurso($dado['co_grupo']);
                        $desempenho->setIdDimOrganizacao($dado['co_orgac']);
                        $desempenho->setIdDimAno($dado['nu_ano']);
                        $desempenho->setIdDimAluno($dimAluno);
                        $desempenho->setNotaComponenteEspecifico(is_null($dado['nt_ce']) ? 0 : $dado['nt_ce']);
                        $desempenho->setNotaTotal(is_null($dado['nt_ger']) ? 0 : $dado['nt_ger']);
                        $this->getDoctrine()->getManager()->persist($desempenho);

                    }

                    $this->getDoctrine()->getManager()->flush();

                    $start = $start + $limit;
                }

                $exame->setCarregado(true);
                $this->getDoctrine()->getManager()->persist($exame);
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->redirect($this->generateUrl('exame_index'));

        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit;
        }
    }

    public function getTurno($dado)
    {
        $todoOsTurnos = ['Matutino' => $dado['in_matutino'], 'Vespertino' => $dado['in_vespertino'], 'Noturno' => $dado['in_noturno']];

        $todosAtivos = array_filter($todoOsTurnos);

        if (count($todosAtivos) > 1) {
            return 'Integral';
        }

        if (empty($todosAtivos)) {
            return 'Indefinido';
        }

        return key($todosAtivos);
    }

}
