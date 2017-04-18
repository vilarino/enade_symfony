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
        try {
            $examesNaoCarregados = $this->getDoctrine()->getRepository('AppBundle:Exame')->findBy(['carregado' => false]);

            $tipo = $this->getDoctrine()->getRepository('AppBundle:Tipo')->find(Tipo::DICIONARIO);

            foreach ($examesNaoCarregados as $exame) {

                $arquivoDicionario = $exame->getArquivos()->filter(function ($arquivo) {
                    return $arquivo->getTipo()->getId() === Tipo::DICIONARIO;
                });

                $regioes = $this->get('extracao')->extrairRegioes($arquivoDicionario->first());

                $this->get('carga')->carregarRegioes($regioes);
            }


        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            exit;
        }

    }

}
