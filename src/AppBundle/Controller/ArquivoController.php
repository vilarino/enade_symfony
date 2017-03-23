<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Arquivo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Arquivo controller.
 *
 * @Route("arquivo")
 */
class ArquivoController extends Controller
{
    /**
     * Lists all arquivo entities.
     *
     * @Route("/", name="arquivo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $arquivos = $em->getRepository('AppBundle:Arquivo')->findAll();

        return $this->render('arquivo/index.html.twig', array(
            'arquivos' => $arquivos,
        ));
    }

    /**
     * Creates a new arquivo entity.
     * @Route("/new", name="arquivo_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $arquivo = new Arquivo();
        $form = $this->createForm('AppBundle\Form\ArquivoType', $arquivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $arquivoPost = $request->files->get('appbundle_arquivo');

            $arquivo->setMimeTypeArquivo($arquivoPost['arquivoVich']->getClientMimeType());
            $arquivo->setNomeArquivo($arquivoPost['arquivoVich']->getClientOriginalName());


            $em = $this->getDoctrine()->getManager();
            $em->persist($arquivo);
            $em->flush($arquivo);

            return $this->redirectToRoute('arquivo_show', array('id' => $arquivo->getId()));
        }

        return $this->render('arquivo/new.html.twig', array(
            'arquivo' => $arquivo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a arquivo entity.
     *
     * @Route("/{id}", name="arquivo_show")
     * @Method("GET")
     */
    public function showAction(Arquivo $arquivo)
    {
        $deleteForm = $this->createDeleteForm($arquivo);

        return $this->render('arquivo/show.html.twig', array(
            'arquivo' => $arquivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

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
            ->getForm()
        ;
    }
}
