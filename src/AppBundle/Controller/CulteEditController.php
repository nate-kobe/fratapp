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

    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/band/edit", name="app_culteedit_band")
     * @Method({"GET", "POST"})
     */
    public function editBandAction(Request $request, Culte $culte)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_WORSHIP')) {
            throw $this->createAccessDeniedException();
        }
        $doctrine = $this->getDoctrine();
        $userGroup = $doctrine->getRepository(SecurityGroup::class)->findOneByRole('ROLE_WORSHIP');

        $editForm = $this->createForm('AppBundle\Form\CulteBandType', $culte, array('user_group' => $userGroup));
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

    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/img/edit", name="app_culteedit_img")
     * @Method({"GET", "POST"})
     */
    public function editImageAction(Request $request, Culte $culte) {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_DESIGN')) {
            throw $this->createAccessDeniedException();
        }
        if($culte->getBanner()) {
            $culte->setBanner(new File($this->getParameter('message_banner_directory').'/'.$culte->getBanner()));
        }
        $editForm = $this->createForm('AppBundle\Form\DesignType', $culte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $culte->getBanner();
            if($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('message_banner_directory'),
                    $fileName
                );
                $culte->setBanner($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_culte_show', array('id' => $culte->getId()));
        }

        return $this->render('culte/design_edit.html.twig', array(
            'culte' => $culte,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/president/edit", name="app_culteedit_president")
     * @Method({"GET", "POST"})
     */
    public function editPresidentAction(Request $request, Culte $culte)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_PRESIDENT')) {
            throw $this->createAccessDeniedException();
        }
        $doctrine = $this->getDoctrine();
        $userGroup = $doctrine->getRepository(SecurityGroup::class)->findOneByRole('ROLE_PRESIDENT');

        $editForm = $this->createForm('AppBundle\Form\CultePresidentType', $culte, array('user_group' => $userGroup));
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
