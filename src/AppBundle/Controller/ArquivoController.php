<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Arquivo;
use AppBundle\Entity\Exame;
use AppBundle\Form\ArquivoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Arquivo controller.
 *
 * @Route("/exame/arquivos")
 */
class ArquivoController extends Controller
{

    /**
     * @param Exame $exame
     * @Route("/{exame}", name="arquivo_index")
     * @Method("GET")
     * @ParamConverter("exame", class="AppBundle:Exame", options={"id" = "exame"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Exame $exame)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Home", "homepage");
        $breadcrumbs->addRouteItem("Exame", "exame_index");
        $breadcrumbs->addRouteItem("Planilhas", "arquivo_index", array(
            'exame' => $exame->getId()
        ));

        return $this->render('arquivo/index.html.twig', array(
            'exame' => $exame,
        ));
    }

    /**
     * Creates a new arquivo entity.
     * @Route("/new/{exame}", name="arquivo_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("exame", class="AppBundle:Exame", options={"id" = "exame"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Exame $exame)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem("Home", "homepage");
        $breadcrumbs->addRouteItem("Exame", "exame_index");
        $breadcrumbs->addRouteItem("Planilhas", "arquivo_index", array(
            'exame' => $exame->getId()
        ));
        $breadcrumbs->addRouteItem("Nova  Planilha", "exame_index");

        $arquivo = new Arquivo();
        $arquivo->setExame($exame);
        $form = $this->createForm(ArquivoType::class, $arquivo, array(
            'action' => $this->generateUrl('arquivo_new',
                array(
                    'exame' => $exame->getId()
                )
            )
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $arquivoPost = $request->files->get('appbundle_arquivo');
            $arquivo->setMimeTypeArquivo($arquivoPost['arquivoVich']->getClientMimeType());
            $arquivo->setNomeArquivo($arquivoPost['arquivoVich']->getClientOriginalName());

            $em = $this->getDoctrine()->getManager();
            $em->persist($arquivo);
            $em->flush($arquivo);

            return $this->redirectToRoute('arquivo_index', array('exame' => $exame->getId()));
        }

        return $this->render('arquivo/new.html.twig', array(
            'arquivo' => $arquivo,
            'form' => $form->createView(),
        ));
    }

//    /*/**
//     * Finds and displays a arquivo entity.
//     *
//     * @Route("/{id}", name="arquivo_show")
//     * @Method("GET")
//     */
//    public function showAction(Arquivo $arquivo)
//    {
//        $deleteForm = $this->createDeleteForm($arquivo);
//
//        return $this->render('arquivo/show.html.twig', array(
//            'arquivo' => $arquivo,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }*/

    /**
     * Displays a form to edit an existing arquivo entity.
     *
     * @Route("/{id}/edit", name="arquivo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Arquivo $arquivo)
    {
        $deleteForm = $this->createDeleteForm($arquivo);
        $editForm = $this->createForm('AppBundle\Form\ArquivoType', $arquivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('arquivo_edit', array('id' => $arquivo->getId()));
        }

        return $this->render('arquivo/edit.html.twig', array(
            'arquivo' => $arquivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a arquivo entity.
     *
     * @Route("/{id}", name="arquivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Arquivo $arquivo)
    {
        $form = $this->createDeleteForm($arquivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($arquivo);
            $em->flush($arquivo);
        }

        return $this->redirectToRoute('arquivo_index');
    }

    /**
     * Creates a form to delete a arquivo entity.
     *
     * @param Arquivo $arquivo The arquivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Arquivo $arquivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('arquivo_delete', array('id' => $arquivo->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
