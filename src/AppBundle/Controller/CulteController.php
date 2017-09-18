<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Culte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Culte controller.
 *
 * @Route("app/culte")
 */
class CulteController extends Controller
{
    /**
     * Lists all culte entities.
     *
     * @Route("/", name="app_culte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cultes = $em->getRepository('AppBundle:Culte')->findAll();

        return $this->render('culte/index.html.twig', array(
            'cultes' => $cultes,
        ));
    }

    /**
     * Creates a new culte entity.
     *
     * @Route("/new", name="app_culte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $culte = new Culte();
        $form = $this->createForm('AppBundle\Form\CulteType', $culte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($culte);
            $em->flush();

            return $this->redirectToRoute('app_culte_show', array('id' => $culte->getId()));
        }

        return $this->render('culte/new.html.twig', array(
            'culte' => $culte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a culte entity.
     *
     * @Route("/{id}", name="app_culte_show")
     * @Method("GET")
     */
    public function showAction(Culte $culte)
    {
        $deleteForm = $this->createDeleteForm($culte);

        return $this->render('culte/show.html.twig', array(
            'culte' => $culte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing culte entity.
     *
     * @Route("/{id}/edit", name="app_culte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Culte $culte)
    {
        $deleteForm = $this->createDeleteForm($culte);
        $editForm = $this->createForm('AppBundle\Form\CulteType', $culte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_culte_edit', array('id' => $culte->getId()));
        }

        return $this->render('culte/edit.html.twig', array(
            'culte' => $culte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a culte entity.
     *
     * @Route("/{id}", name="app_culte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Culte $culte)
    {
        $form = $this->createDeleteForm($culte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($culte);
            $em->flush();
        }

        return $this->redirectToRoute('app_culte_index');
    }

    /**
     * Creates a form to delete a culte entity.
     *
     * @param Culte $culte The culte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Culte $culte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app_culte_delete', array('id' => $culte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
