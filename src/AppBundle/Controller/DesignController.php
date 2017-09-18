<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Culte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Culte controller for design actions
 *
 * @Route("app/design")
 */
class DesignController extends Controller
{
    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/update", name="app_culte_design_update")
     * @Method({"GET","POST"})
     */
    public function updateAction(Request $request, Culte $culte)
    {
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
}
