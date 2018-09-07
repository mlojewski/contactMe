<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    /**
     * @Route("/CreateNew")
     */
    public function CreateNewAction(Request $request)
    {
        $newPerson = new Person();
        $personForm=$this->createFormBuilder($newPerson)->add('name', TextType::class, array('attr'=> array('maxlength'=>200)))->add('surname', TextType::class, array('attr'=>array('maxlength'=>200)))
        ->add ('description', TextType::class, array('attr'=>array('maxlength'=>2000)))->add('photo', TextType::class, array('attr'=>array('maxlength'=>200)))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $personForm->handleRequest($request);
        if ($personForm->isSubmitted() && $personForm->isValid()){
            $newPerson=$personForm->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($newPerson);
            $em->flush();
            return $this->redirectToRoute('Add');
        }
        return $this->render('@App/Person/create_new.html.twig', array('form'=>$personForm->createView()));
    }

    /**
     * @Route("/Add", name="Add")
     */
    public function AddAction()
    {
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('SELECT person FROM AppBundle:Person person ORDER BY person.id DESC');
        $newPerson=$query->setMaxResults(1)->getOneOrNullResult();
        return $this->render('@App/Person/add.html.twig', array('newPerson'=> $newPerson));
    }

    /**
     * @Route("/Modify/{id}")
     */
    public function ModifyAction($id,Request $request)
    {
        $personToModify=$this->getDoctrine()->getRepository('AppBundle:Person')->find($id);
       if (!$personToModify){
           return new Response("nie ma osoby o id: ".$id);
       }
       $personToModify->setName($personToModify->getName());
        $personToModify->setSurname($personToModify->getSurname());
        $personToModify->setDescription($personToModify->getDescription());
        $personToModify->setPhoto($personToModify->getPhoto());
        $personForm=$this->createFormBuilder($personToModify)->add('name', TextType::class, array('attr'=> array('maxlength'=>200)))->add('surname', TextType::class, array('attr'=>array('maxlength'=>200)))
            ->add ('description', TextType::class, array('attr'=>array('maxlength'=>2000)))->add('photo', TextType::class, array('attr'=>array('maxlength'=>200)))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $personForm->handleRequest($request);
        if ($personForm->isSubmitted() && $personForm->isValid()){
            $em=$this->getDoctrine()->getManager();
            $personToModify=$em->getRepository('AppBundle:Person')->find($id);
            $name=$personForm['name']->getData();
            $personToModify->setName($name);
            $surname=$personForm['surname']->getData();
            $personToModify->setSurname($surname);
            $description=$personForm['description']->getData();
            $personToModify->setDescription($description);
            $photo=$personForm['photo']->getData();
            $personToModify->setPhoto($photo);
            $em->flush();
            return $this->redirectToRoute('show');
        }
        return $this->render('@App/Person/modify.html.twig', array('personForm'=>$personForm->createView()));
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
     * @Route("/Show", name="show")
     */
    public function ShowAction()
    {
        return $this->render('@App/Person/show.html.twig');
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
