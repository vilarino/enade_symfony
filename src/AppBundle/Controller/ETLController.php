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
        set_time_limit(60 * 10);

        try {
            $examesNaoCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => false]);

            $tipo = $this->getDoctrine()->getRepository('AppBundle:Tipo')->find(Tipo::DICIONARIO);

            foreach ($examesNaoCarregados as $exame) {

                $arquivoDicionario = $exame->getArquivos()->filter(function ($arquivo) {
                    return $arquivo->getTipo()->getId() === Tipo::DICIONARIO;
                });

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

            }

            $this->addFlash('success', 'Carga realizada com sucesso!');

            return $this->redirect($this->generateUrl('exame_index'));

        } catch (\Exception $exception) {
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

            $this->addFlash('success', 'Registros removidos com sucesso');

            return $this->redirect($this->generateUrl('exame_index'));


        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit;
        }

    }

}
