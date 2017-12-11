<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserInvite;
use AppBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * User controller.
 *
 * @Route("/")
 */
class SecurityController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/login", name="security_login")
     */
    public function loginAction(Request $req, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();


        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/register/{code}", name="security_register")
     */
    public function registerAction(Request $request, $code, UserPasswordEncoderInterface $passwordEncoder) {
        $em = $this->getDoctrine()->getManager();

        $invite = $em->getRepository(UserInvite::Class)->findOneByCode($code);
        if($invite == null || !$invite->isValid()) return $this->render('security/error_invite_invalid.html.twig');
        $user = $invite->getUser();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($invite); 
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPwd($password);
            $user->setDtCreated(new \DateTime());
            $user->setState(1);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView(),
                    'inviter' => $invite->getInviter())
        );
    }

    /**
     * @Route("/reset-pwd", name="security_reset_pwd")
     */
    public function resetPwdAction(Request $request) {
        if ($user = $this->getUser()) {
            echo $user->getUsername();
        }
        $this->redirectToRoute('homepage');
    }
}
