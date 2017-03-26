<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ETLController extends Controller
{
    /**
     * @Route("/processo")
     */
    public function processoAction()
    {
        return $this->render('AppBundle:ETL:processo.html.twig', array(
            // ...
        ));
    }

}
