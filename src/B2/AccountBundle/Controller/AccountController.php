<?php
namespace B2\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use B2\AccountBundle\Document\User;
use B2\AccountBundle\Document\LoginForm;




class AccountController extends Controller
{
    // simple form interface
    public function registerAction(Request $request)
    {
        /*print "<pre>";
        print_r($_SESSION);
        print_r($this->get("session"));
        print "</pre>";*/
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = new User();
        $form = $this->createFormBuilder($user,array('action' => $this->generateUrl('account_register'),))
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('password', 'password')
            ->add('save', 'submit', array('label' => 'Create'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {

            $dm->persist($form->getData());
            $dm->flush();

            /*$request->getSession()->setFlash('notice', "Successfully Created.");*/
            return $this->redirect($this->generateUrl('b2_account_show'));
        }else{
            return $this->render(
                'B2AccountBundle:Account:register.html.twig',
                array('form' => $form->createView())
            );
        }



    }


    public function showAction(){
        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('B2AccountBundle:User');

        $users = $repository->findAll();

        return new Response(var_dump($users));

    }

    public function loginAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = new LoginForm();
        $form = $this->createFormBuilder($user,array('action' => $this->generateUrl('account_login'),))
            ->add('email', 'email')
            ->add('password', 'password')
            ->add('save', 'submit', array('label' => 'Login'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {

                $input = $form->getData();

                $repository = $this->get('doctrine_mongodb')
                    ->getManager()
                    ->getRepository('B2AccountBundle:User');

                $person = $repository->findOneBy(
                    array('email' => $input->getEmail())
                    //array('password' => $input->getPassword())
                );

            //var_dump($person);

                /*$person = $this->get('doctrine_mongodb')
                    ->getManager()
                    ->getRepository('B2AccountBundle:User')
                    ->findOneByEmail($input->getEmail());*/

                if (!$person) {
                    throw $this->createNotFoundException('No user found for email : '.$input->getEmail());
                }

                if($input->getEmail() == $person->getEmail() && $input->getPassword() == $person->getPassword() ){
                    echo "Hello Mr. ".$person->getName();
                }else if($input->getEmail() == $person->getEmail() && $input->getPassword() != $person->getPassword()){
                    echo "Wrong Password";

                }
            exit;
            }else{
                return $this->render(
                    'B2AccountBundle:Account:login.html.twig',
                    array('form' => $form->createView())
                );
            }



        }


    }