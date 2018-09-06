<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PersonController extends Controller
{
    /**
     * @Route("/CreateNew")
     */
    public function CreateNewAction()
    {
        return $this->render('AppBundle:Person:create_new.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/Add")
     */
    public function AddAction()
    {
        return $this->render('AppBundle:Person:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/Modify")
     */
    public function ModifyAction()
    {
        return $this->render('AppBundle:Person:modify.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/Delete")
     */
    public function DeleteAction()
    {
        return $this->render('AppBundle:Person:delete.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/Show")
     */
    public function ShowAction()
    {
        return $this->render('AppBundle:Person:show.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/ShowAll")
     */
    public function ShowAllAction()
    {
        return $this->render('AppBundle:Person:show_all.html.twig', array(
            // ...
        ));
    }

}
