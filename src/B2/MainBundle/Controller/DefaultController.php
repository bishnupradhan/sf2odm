<?php

namespace B2\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

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
        /*$user = $this->container->get('security.context')->getToken()->getUser();
        print "<pre>";  print_r($user);
        print "</pre>";
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }*/

        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('B2MainBundle:Category');

        $res = $repository->findAll();

        // for making accordion two column
        $size = sizeof($res);
        $col1 = $col2 = array();
        foreach($res as $index => $val ){
            if($index < round($size/2)){
                array_push($col1,$val);
            }else{
                array_push($col2,$val);
            }

        }
        return $this->render('B2MainBundle:Default:listing.html.twig',array('col1' => $col1,'col2' => $col2));
    }

    public function catListingAction($cat){

        $dm = $this->get('doctrine_mongodb')->getManager();

        $qb = $dm->createQueryBuilder("B2MainBundle:Category")
            ->hydrate(false)
            ->field('category')->equals(strtolower(trim($cat)));
        $query = $qb->getQuery();
        $getCategoryContent = $query->getSingleResult();

        if(!empty($getCategoryContent)){
            return $this->render('B2MainBundle:Default:catListing.html.twig',array('data' => $getCategoryContent));
        }else{
            $this->get('session')->getFlashBag()->add( 'error','No matching category found. Please select from the list once again.');
            return $this->redirect($this->generateUrl("main_list"));
        }

    }

}

