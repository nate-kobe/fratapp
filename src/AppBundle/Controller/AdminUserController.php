<?php

namespace AppBundle\Controller;

// Internal app imports
use AppBundle\Entity\User;
use AppBundle\Entity\UserInvite;
use AppBundle\Entity\SecurityGroup;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("admin/user")
 */
class AdminUserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }
    
    /**
     * Creates a new user entity.
     *
     * @Route("/invite", name="admin_user_invite")
     * @Method({"GET", "POST"})
     */
    public function inviteAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')
            ->getToken()
            ->getUser();
        $invite = new UserInvite();

        $form = $this->createForm('AppBundle\Form\UserInviteType', $invite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invite->setInviter($currentUser);
            $invite->setDtCreated(new \DateTime());
            $invite->setCode($this->genRandStr());
            $user = new User();
            $user->setDtCreated(new \DateTime());
            $user->setEmail($invite->getEmail());
            $user->setPwd($this->genRandStr());
            $user->setState(0);
            $invite->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($invite);
            $em->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/invite.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // /**
    //  * Creates a new user entity.
    //  *
    //  * @Route("/new", name="admin_user_new")
    //  * @Method({"GET", "POST"})
    //  */
    // public function newAction(Request $request)
    // {
    //     $user = new User();
    //     $form = $this->createForm('AppBundle\Form\UserType', $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $user->setDtCreated(new \DateTime());
    //         $user->setPwd($this->genRandStr());

    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($user);
    //         $em->flush();

    //         return $this->redirectToRoute('admin_user_show', array('id' => $user->getId()));
    //     }

    //     return $this->render('user/new.html.twig', array(
    //         'user' => $user,
    //         'form' => $form->createView(),
    //     ));
    // }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }


    /**
     * Adds a role to a user
     *
     * @Route("/{userId}/promote/{groupId}", name="admin_user_promote")
     * @Method({"GET"})
     */
    public function promote(int $userId, int $groupId) {

        // Get group
        $groupRep = $this->getDoctrine()->getRepository(SecurityGroup::Class);
        $group = $groupRep->find($groupId);

        // Get user
        $userRep = $this->getDoctrine()->getRepository(User::Class);
        $user = $userRep->find($userId);

        $group->addUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user); $em->persist($group);
        $em->flush();

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Adds a role to a user
     *
     * @Route("/{userId}/demote/{groupId}", name="admin_user_demote")
     * @Method({"GET"})
     */
    public function demote(int $userId, int $groupId) {

        // Get group
        $groupRep = $this->getDoctrine()->getRepository(SecurityGroup::Class);
        $group = $groupRep->find($groupId);

        // Get user
        $userRep = $this->getDoctrine()->getRepository(User::Class);
        $user = $userRep->find($userId);

        $group->removeUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user); $em->persist($group);
        $em->flush();

        return $this->redirectToRoute('admin_user_index');  
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Generates a random string
     */
    private function genRandStr($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$_.,()!?&%*+-';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
