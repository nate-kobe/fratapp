<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Culte;
use AppBundle\Entity\SecurityGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Culte Edit controller.
 *
 * @Route("app/culte")
 */
class CulteEditController extends Controller
{
    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/sono/edit", name="app_culteedit_sono")
     * @Method({"GET", "POST"})
     */
    public function editSonoAction(Request $request, Culte $culte)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_SONO')) {
            throw $this->createAccessDeniedException();
        }
        $doctrine = $this->getDoctrine();
        $sonoGroup = $doctrine->getRepository(SecurityGroup::class)->findOneByRole('ROLE_SONO');

        $editForm = $this->createForm('AppBundle\Form\CulteSonoType', $culte, array('sono_group' => $sonoGroup));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_culte_show', array('id' => $culte->getId()));
        }

        return $this->render('culte/sono.html.twig', array(
            'culte' => $culte,
            'edit_form' => $editForm->createView()
        ));
    }
}
