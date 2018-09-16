<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Phone;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller
{
    /**
     * @Route("/add_phone", name="add_phone")
     */
    public function add_phoneAction()
    {
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('SELECT phone FROM AppBundle:Phone phone ORDER BY phone.id DESC');
        $newPhone=$query->setMaxResults(1)->getOneOrNullResult();
        return $this->render('@App/Phone/add.phone.html.twig', array('newPhone'=> $newPhone));
    }

    /**
     * @Route("/create_phone")
     */
    public function create_phoneAction(Request $request)
    {
        $newPhone= new Phone;
        $phoneForm=$this->createFormBuilder($newPhone)->add('number', TextType::class, array('attr'=>array('maxlength'=>200)))
            ->add('type', ChoiceType::class, array('choices'=> array('mobile'=>"mobile", 'business'=>"business", 'home'=>"home", 'other'=>"other")))
            ->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $phoneForm->handleRequest($request);
        if ($phoneForm->isSubmitted() && $phoneForm->isValid()){
            $newPhone=$phoneForm->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($newPhone);
            $em->flush();
            return $this->redirectToRoute('add_phone');
        }
        return $this->render('@App/Phone/create.phone.html.twig', array('form'=>$phoneForm->createView()));
    }

    /**
     * @Route("/modify_phone/{id}")
     */
    public function modify_phoneAction($id, Request $request)
    {
        $phoneToModify=$this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);
        if (!$phoneToModify){
            return new Response('nie ma numeru o id '.$id);
        }
        $phoneToModify->setNumber($phoneToModify->getNumber());
        $phoneToModify->setType($phoneToModify->getType());
        $phoneToModify->setPerson($phoneToModify->getPerson());
        $phoneForm=$this->createFormBuilder($phoneToModify)->add('number', TextType::class, array('attr'=>array('maxlength'=>200)))
            ->add('type', ChoiceType::class, array('choices'=> array('mobile'=>"mobile", 'business'=>"business", 'home'=>"home", 'other'=>"other")))
            ->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $phoneForm->handleRequest($request);
        if ($phoneForm->isValid() && $phoneForm->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $number=$phoneForm['number']->getData();
            $type=$phoneForm['type']->getData();
            $person=$phoneForm['person']->getData();
            $phoneToModify=$this->getDoctrine()->getRepository('AppBundle:Phone')->find($id);
            $phoneToModify->setNumber($number);
            $phoneToModify->setType($type);
            $phoneToModify->setPerson($person);
            $em->flush();
            return $this->redirectToRoute('showall');
        }
        return $this->render('@App/Phone/modify.phone.html.twig', array ('form'=>$phoneForm->createView()));
    }

}
