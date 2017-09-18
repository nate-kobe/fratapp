<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SecurityGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Securitygroup controller.
 *
 * @Route("sadmin/sec-groups")
 */
class SecurityGroupController extends Controller
{
    /**
     * Lists all securityGroup entities.
     *
     * @Route("/", name="sadmin_sec-groups_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $securityGroups = $em->getRepository('AppBundle:SecurityGroup')->findAll();

        return $this->render('securitygroup/index.html.twig', array(
            'securityGroups' => $securityGroups,
        ));
    }

    /**
     * Creates a new securityGroup entity.
     *
     * @Route("/new", name="sadmin_sec-groups_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $securityGroup = new Securitygroup();
        $form = $this->createForm('AppBundle\Form\SecurityGroupType', $securityGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($securityGroup);
            $em->flush();

            return $this->redirectToRoute('sadmin_sec-groups_show', array('id' => $securityGroup->getId()));
        }

        return $this->render('securitygroup/new.html.twig', array(
            'securityGroup' => $securityGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a securityGroup entity.
     *
     * @Route("/{id}", name="sadmin_sec-groups_show")
     * @Method("GET")
     */
    public function showAction(SecurityGroup $securityGroup)
    {
        $deleteForm = $this->createDeleteForm($securityGroup);

        return $this->render('securitygroup/show.html.twig', array(
            'securityGroup' => $securityGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing securityGroup entity.
     *
     * @Route("/{id}/edit", name="sadmin_sec-groups_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SecurityGroup $securityGroup)
    {
        $deleteForm = $this->createDeleteForm($securityGroup);
        $editForm = $this->createForm('AppBundle\Form\SecurityGroupType', $securityGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sadmin_sec-groups_edit', array('id' => $securityGroup->getId()));
        }

        return $this->render('securitygroup/edit.html.twig', array(
            'securityGroup' => $securityGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a securityGroup entity.
     *
     * @Route("/{id}", name="sadmin_sec-groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SecurityGroup $securityGroup)
    {
        $form = $this->createDeleteForm($securityGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($securityGroup);
            $em->flush();
        }

        return $this->redirectToRoute('sadmin_sec-groups_index');
    }

    /**
     * Creates a form to delete a securityGroup entity.
     *
     * @param SecurityGroup $securityGroup The securityGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SecurityGroup $securityGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sadmin_sec-groups_delete', array('id' => $securityGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
