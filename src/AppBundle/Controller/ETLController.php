<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Tipo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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

            $tipo = $this->getDoctrine()->getRepository('AppBundle:Tipo')->find(Tipo::DICIONARIO);

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

                /*$arquivoDados = $exame->getArquivos()->filter(function ($arquivo) {
                    return $arquivo->getTipo()->getId() === Tipo::DADOS;
                });*/

                /*$dados = $this->get('extracao')->extrairDados($arquivoDados->first());*/

                /*$this->get('carga')->carregarDados($dados);*/

                /*$exame->setCarregado(true);*/

                $this->getDoctrine()->getManager()->persist($exame);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Carga realizada com sucesso!');

            return $this->redirect($this->generateUrl('exame_index'));

        } catch (\Exception $exception) {
//            echo($exception->getTraceAsString());
            var_dump($exception->getMessage());
            exit;
        }

    }

    /**
     * @Route("/limpar", name="limpar")
     * @Method("GET")
     */
    public function limparAction()
    {
        set_time_limit(60 * 10);

        try {

            $this->get('descarga')->descargaRegioes();
            $this->get('descarga')->descargaEstados();
            $this->get('descarga')->descargaCidades();
            $this->get('descarga')->descargaCursos();
            $this->get('descarga')->descargaOrganizacoes();
            $this->get('descarga')->descargaAnos();

            $this->addFlash('success', 'Registros removidos com sucesso');

            $examesNaoCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => true]);
            foreach ($examesNaoCarregados as $exame){
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

}
