<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Instrument;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Instrument controller.
 *
 * @Route("sadmin/instrument")
 */
class InstrumentController extends Controller
{
    /**
     * Lists all instrument entities.
     *
     * @Route("/", name="sadmin_instrument_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $instruments = $em->getRepository('AppBundle:Instrument')->findAll();

        return $this->render('instrument/index.html.twig', array(
            'instruments' => $instruments,
        ));
    }

    /**
     * Creates a new instrument entity.
     *
     * @Route("/new", name="sadmin_instrument_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $instrument = new Instrument();
        $form = $this->createForm('AppBundle\Form\InstrumentType', $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($instrument);
            $em->flush();

            return $this->redirectToRoute('sadmin_instrument_show', array('id' => $instrument->getId()));
        }

        return $this->render('instrument/new.html.twig', array(
            'instrument' => $instrument,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a instrument entity.
     *
     * @Route("/{id}", name="sadmin_instrument_show")
     * @Method("GET")
     */
    public function showAction(Instrument $instrument)
    {
        $deleteForm = $this->createDeleteForm($instrument);

        return $this->render('instrument/show.html.twig', array(
            'instrument' => $instrument,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing instrument entity.
     *
     * @Route("/{id}/edit", name="sadmin_instrument_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Instrument $instrument)
    {
        $deleteForm = $this->createDeleteForm($instrument);
        $editForm = $this->createForm('AppBundle\Form\InstrumentType', $instrument);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sadmin_instrument_edit', array('id' => $instrument->getId()));
        }

        return $this->render('instrument/edit.html.twig', array(
            'instrument' => $instrument,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a instrument entity.
     *
     * @Route("/{id}", name="sadmin_instrument_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Instrument $instrument)
    {
        $form = $this->createDeleteForm($instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($instrument);
            $em->flush();
        }

        return $this->redirectToRoute('sadmin_instrument_index');
    }

    /**
     * Creates a form to delete a instrument entity.
     *
     * @param Instrument $instrument The instrument entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Instrument $instrument)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sadmin_instrument_delete', array('id' => $instrument->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
