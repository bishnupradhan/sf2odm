<?php

namespace B2\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use B2\MainBundle\Document;
use B2\MainBundle\Model;    // to be removed
use B2\MainBundle\AnswerSheet;

use B2\MainBundle\Document\Category;
use B2\MainBundle\Document\UserTest;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('B2MainBundle:Default:index.html.twig');
    }

    public function listingAction(){

        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('B2MainBundle:Category');

        $cat = $repository->findAll();

        //print "<pre>";print_r($cat);print "</pre>";exit;

        return $this->render('B2MainBundle:Default:listing.html.twig',array('data' => $cat));
    }



}

