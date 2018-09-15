<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * @Route("/Add_address", name="Add_address")
     */
    public function AddAction()
    {
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('SELECT address FROM AppBundle:Address address ORDER BY address.id DESC');
        $newAddress=$query->setMaxResults(1)->getOneOrNullResult();
        return $this->render('@App/Address/Add_address.html.twig', array('newAddress'=> $newAddress));
    }
    /**
     * @Route("/create_address")
     */
    public function CreateAction(Request $request)
    {
       $newAddress= new Address();
       $addressForm=$this->createFormBuilder($newAddress)->add('city', TextType::class, array('attr'=> array('maxlength'=>100)))->add('street', TextType::class, array('attr'=> array('maxlength'=>250)))
           ->add('houseNumber',IntegerType::class, array('attr'=>array('min'=>0)))->add('flatNumber', IntegerType::class, array('attr'=>array('min'=>0)))
           ->add('postalCode', TextType::class, array('attr'=> array('maxlength'=>6)))->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
       $addressForm->handleRequest($request);
       if ($addressForm->isValid() && $addressForm->isSubmitted()){
           $newAddress=$addressForm->getData();
           $em=$this->getDoctrine()->getManager();
           $em->persist($newAddress);
           $em->flush();
           return $this->redirectToRoute('Add_address');
       }

       return $this->render('@App/Address/create_address.html.twig', array('form'=>$addressForm->createView()));
    }

    /**
     * @Route("/Modify_address/{id}")
     */
    public function ModifyAction($id, Request $request)
    {
        $addressToModify=$this->getDoctrine()->getRepository('AppBundle:Address')->find($id);
        if (!$addressToModify){
            return new Response("nie ma adresu o id ".$id);
        }
        $addressToModify->setPerson($addressToModify->getPerson());
        $addressToModify->setCity($addressToModify->getCity());
        $addressToModify->setStreet($addressToModify->getStreet());
        $addressToModify->setHouseNumber($addressToModify->getHouseNumber());
        $addressToModify->setFlatNumber($addressToModify->getFlatNumber());
        $addressToModify->setPostalCode($addressToModify->getPostalCode());
        $addressForm=$this->createFormBuilder($addressToModify)->add('city', TextType::class, array('attr'=> array('maxlength'=>100)))->add('street', TextType::class, array('attr'=> array('maxlength'=>250)))
            ->add('houseNumber',IntegerType::class, array('attr'=>array('min'=>0)))->add('flatNumber', IntegerType::class, array('attr'=>array('min'=>0)))
            ->add('postalCode', TextType::class, array('attr'=> array('maxlength'=>6)))->add('person', EntityType::class, array('class'=>'AppBundle:Person', 'choice_label'=>'surname'))->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))->getForm();
        $addressForm->handleRequest($request);
        if ($addressForm->isSubmitted() && $addressForm->isValid()){
            $em=$this->getDoctrine()->getManager();
        $person=$addressForm['person']->getData();
        $city=$addressForm['city']->getData();
        $street=$addressForm['street']->getData();
        $houseNumber=$addressForm['houseNumber']->getData();
        $flatNumber=$addressForm['flatNumber']->getData();
        $postalCode=$addressForm['postalCode']->getData();
        $addressToModify=$this->getDoctrine()->getRepository('AppBundle:Address')->find($id);
            $addressToModify->setPerson($person);
            $addressToModify->setCity($city);
            $addressToModify->setStreet($street);
            $addressToModify->setHouseNumber($houseNumber);
            $addressToModify->setFlatNumber($flatNumber);
            $addressToModify->setPostalCode($postalCode);
            $em->flush();
            return $this->redirectToRoute('showall');
        }
        return $this->render('@App/Address/modify_address.html.twig', array('addressForm'=>$addressForm->createView()));
    }



}
