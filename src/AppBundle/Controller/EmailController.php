<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Email;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends Controller
{
    /**
     * @Route("/add_email", name="add_email")
     */
    public function add_emailAction()
    {
        return $this->render('@App/Email/add.email.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/create_email")
     */
    public function create_emailAction(Request $request)
    {
       $newEmail= new Email();
       $emailForm=$this->createFormBuilder($newEmail)->add('email_address', TextType::Class, array('attr'=>array('maxlength'=>200)))->add('type', ChoiceType::class, array('choices'=> array('personal'=>"personal",
           'business'=>"business", 'spam'=>"spam", 'other'=>"other")))->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $emailForm->handleRequest($request);
        if ($emailForm->isSubmitted() && $emailForm->isValid()){
            $newEmail=$emailForm->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($newEmail);
            $em->flush();
            return $this->redirectToRoute('add_email');
        }
        return $this->render('@App/Email/create.email.html.twig', array('form'=>$emailForm->createView()));
    }

    /**
     * @Route("/modify_email/{id}")
     */
    public function modify_emailAction($id, Request $request)
    {
        $emailToModify=$this->getDoctrine()->getRepository('AppBundle:Email')->find($id);
        if (!$emailToModify){
            return new Response('nie ma emaila o id '.$id);
        }
        $emailToModify->setEmailAddress($emailToModify->getEmailAddress());
        $emailToModify->setType($emailToModify->getType());
        $emailToModify->setPerson($emailToModify->getPerson());
        $emailForm=$this->createFormBuilder($emailToModify)->add('email_address', TextType::Class, array('attr'=>array('maxlength'=>200)))->add('type', ChoiceType::class, array('choices'=> array('personal'=>"personal",
            'business'=>"business", 'spam'=>"spam", 'other'=>"other")))->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $emailForm->handleRequest($request);
        if ($emailForm->isValid() && $emailForm->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $address=$emailForm['email_address']->getData();
            $type=$emailForm['type']->getData();
            $person=$emailForm['person']->getData();
            $emailToModify=$this->getDoctrine()->getRepository('AppBundle:Email')->find($id);
            $emailToModify->setEmailAddress($address);
            $emailToModify->setType($type);
            $emailToModify->setPerson($person);
            $em->flush();
            return $this->redirectToRoute('showall');
        }
        return $this->render('@App/Email/modify.email.html.twig', array ('form'=>$emailForm->createView()));
    }
}
