<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Culte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Culte controller for preacher's actions
 *
 * @Route("app/sermon")
 */
class SermonController extends Controller
{
    /**
     * Lists all culte entities.
     *
     * @Route("/{id}/update", name="app_culte_preacher_update")
     * @Method({"GET","POST"})
     */
    public function updateAction(Request $request, Culte $culte)
    {
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_PREACHER')) {
            throw $this->createAccessDeniedException();
        }
        if($culte->getPresentation()) {
            $culte->setPresentation(new File($this->getParameter('message_presentation_directory').'/'.$culte->getPresentation()));
        }
        $editForm = $this->createForm('AppBundle\Form\SermonType', $culte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $culte->getPresentation();
            if($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('message_presentation_directory'),
                    $fileName
                );
                $culte->setPresentation($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_culte_show', array('id' => $culte->getId()));
        }

        return $this->render('culte/sermon.html.twig', array(
            'culte' => $culte,
            'edit_form' => $editForm->createView()
        ));
    }
}
