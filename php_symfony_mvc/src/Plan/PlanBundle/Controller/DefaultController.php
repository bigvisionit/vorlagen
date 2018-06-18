<?php

namespace Plan\PlanBundle\Controller;

use Plan\PlanBundle\Entity\Plan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DefaultController extends Controller {

    /**
     * @Route("/", name="start")
     */
    public function indexAction() {

        $plan = $this ->getDoctrine()
            ->getRepository('PlanPlanBundle:Plan')
            ->findAll();
        
        return $this->render('plan/index.html.twig', array('plan' => $plan));

    }
    
    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request) {

        $plan = new Plan();

        $form = $this->createFormBuilder($plan)
            ->add('name', TextType::class, array('attr'=>array('class' => 'form-control', 'style' => 'margin-bottom:1.5em; width:50%;')), array('constraints' => new NotBlank()))
            ->add('place', TextType::class, array( 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:1.5em; width:50%;')))
            ->add('date', DateTimeType::class,array('attr' => array('style' => 'margin-bottom:1.5em; width:50%;')))
            ->add('save', SubmitType::class, array('label' => 'Abschicken', 'attr' => array('class' => 'btn btn-primary')))
            ->getForm();
     
        $form->handleRequest($request);

        if($form->isValid()) {

            //Variablen mit Formulardaten füttern

            $name = $form['name']->getData();

            $place = $form['place'] ->getData();

            $date = $form['date'] ->getData();

            //Setter setzen
            
            $plan->setName($name);

            $plan->setPlace($place);

            $plan->setDate($date);

            //Doctrine aktivieren
            
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($plan);
            
            $em->flush();

            return $this->redirectToRoute('start');
        }

        return $this->render('plan/add.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsAction($id) {

        $plan = $this ->getDoctrine()
            ->getRepository('PlanPlanBundle:Plan')
            ->find($id);
           
        return $this->render('plan/details.html.twig', array('plan' => $plan));
        
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editAction($id, Request $request) {
    
        $plan = $this ->getDoctrine()
            ->getRepository('PlanPlanBundle:Plan')
            ->find($id);
        
        $plan->setName($plan->getName());

        $plan->setPlace($plan->getPlace());

        $plan->setDate($plan->getDate());
     
        $form = $this->createFormBuilder($plan)
             ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:1.5em; width:50%;')), array('constraints' =>  new NotBlank()))
             ->add('place', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:1.5em; width:50%;')))
             ->add('date', DateTimeType::class, array('attr' => array( 'style' => 'margin-bottom:1.5em; width:50%;')))
             ->add('save', SubmitType::class, array('label' => 'Abschicken', 'attr' => array('class' => 'btn btn-primary')))
             ->getForm();
      
        $form->handleRequest($request);

        if($form->isValid()) {

            //Variablen mit Formulardaten füttern

            $name = $form['name']->getData();
            
            $place = $form['place'] ->getData();
            
            $date = $form['date'] ->getData();
        
            
            //Doctrine aktivieren
            
            $em=$this->getDoctrine()->getManager();
            
            $plan = $em->getRepository('PlanPlanBundle:Plan')->find($id);
            
            $em->flush();

            return $this->redirectToRoute('start');

        }           
    
        return $this->render('plan/edit.html.twig', array(
            'plan' => $plan, 
            'form' => $form->createView()
        ));
      
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id) {

         $em = $this->getDoctrine()->getManager();

         $plan = $em->getRepository('PlanPlanBundle:Plan')->find($id);
         
         $em->remove($plan);

         $em->flush();
         
         return $this->redirectToRoute('start');
    }
    
}