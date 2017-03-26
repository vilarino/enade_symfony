<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Exame;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Exame controller.
 *
 * @Route("exame")
 */
class ExameController extends Controller
{
    /**
     * Lists all exame entities.
     *
     * @Route("/", name="exame_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("homepage"));
        $breadcrumbs->addRouteItem("Exame", "exame_index");

        $em = $this->getDoctrine()->getManager();

        $exames = $em->getRepository('AppBundle:Exame')->findAll();

        return $this->render('exame/index.html.twig', array(
            'exames' => $exames,
        ));
    }

    /**
     * Creates a new exame entity.
     *
     * @Route("/new", name="exame_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Home", "homepage");
        $breadcrumbs->addRouteItem("Exame", "exame_index");
        $breadcrumbs->addRouteItem("Novo Exame", "exame_index");

        $exame = new Exame();
        $form = $this->createForm('AppBundle\Form\ExameType', $exame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($exame);
            $em->flush($exame);

            return $this->redirectToRoute('exame_index');
        }

        return $this->render('exame/new.html.twig', array(
            'exame' => $exame,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing exame entity.
     *
     * @Route("/{id}/edit", name="exame_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Exame $exame)
    {
        $deleteForm = $this->createDeleteForm($exame);
        $editForm = $this->createForm('AppBundle\Form\ExameType', $exame);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exame_edit', array('id' => $exame->getId()));
        }

        return $this->render('exame/edit.html.twig', array(
            'exame' => $exame,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a exame entity.
     *
     * @Route("/{id}", name="exame_delete", options={"expose"=true})
     * @Method({"DELETE","GET"})
     */
    public function deleteAction(Exame $exame)
    {
        if ($exame) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($exame);
            $em->flush();
        }

        return $this->redirectToRoute('exame_index');
    }

    /**
     * Creates a form to delete a exame entity.
     *
     * @param Exame $exame The exame entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Exame $exame)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exame_delete', array('id' => $exame->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
