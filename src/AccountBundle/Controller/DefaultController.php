<?php

namespace AccountBundle\Controller;

use AccountBundle\Entity\Account;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AccountBundle\Form\AccountCreateType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AccountBundle:Default:index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    public function logoutAction() {

    }

    public function loginAction(Request $request) {

        if ($this->getUser()){
            return $this->redirect('account_homepage');
        }

        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('AccountBundle:Default:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function createAction(Request $request)
    {
        if ($this->getUser()){
            return $this->redirect('account_homepage');
        }

        $account = new Account();

        $form = $this->createForm(AccountCreateType::class, $account); //create new form with empty account entity
        $form->handleRequest($request); // 1) if form is not submitted - do nothing. Else fill entity fiels by requested data

        // here we could call $form->submit(data) manually
        /*$errors = $form->getErrors();
        var_dump($errors);*/
        if ($form->isSubmitted() && $form->isValid()) {
            //$passwordEncoder = $this->get('security.password_encoder');
            //$account->setPassword($passwordEncoder->encodePassword($account, $account->getPlainPassword()));
            $account->setPassword($account->getPlainPassword());

            $em = $this->getDoctrine()->getManager(); // get entity manager
            $em->persist($account); // persist changes
            $em->flush();

            return $this->redirect($this->generateUrl(
                'account_login',
                ['id' => $account->getId()]
            ));
        }

        return $this->render('AccountBundle:Default:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction() {

    }

    public function deleteAction() {

    }
}