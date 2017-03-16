<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ReservationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * @Route("/Reservation/restaurant-{nom}",name="reserverRestaurant")
     */
    public function  restaurantAction($nom,Request $request){
        $em= $this->getDoctrine()->getEntityManager();

        $restaurant=$em->getRepository("AppBundle:Restaurant")
            ->findOneBy(['nom'=>$nom]);


           return $this->render('@App/Reservation/restaurant.html.twig',['rest'=>$restaurant]);
    }


    /**
     * @Route("/Reservation/rest/{id}",name="ReserverRestaurant")
     * @param $id
     */
    public function reserverRestaurantAction($id,Request $request){
       $user = $this->getUser();

        $reservation= new Reservation();
        $form= $this->createForm(\AppBundle\Form\ReservationType::class,$reservation);
        if($form->handleRequest($request)->isValid()){
            $em= $this->getDoctrine()->getManager();
            $restaurant=$em->getRepository("AppBundle:Restaurant")
                ->find($id);
            $reservation->setRestaurant($restaurant);
            $reservation->setUser($user);
            $em->persist($reservation);
            $em->flush();
            $this->addFlash('Success','Reservation bien pris en cours add');
            return $this->redirectToRoute("homepage");
        }
        return $this->render("@App/Reservation/reserverrestaurant.html.twig",["form"=>$form->createView()]);

    }
    /**
     * @Route("/Reservation/activite-{nom}",name="reservationActivite")
     */
    public function  activiteAction($nom,Request $request){
        $em= $this->getDoctrine()->getEntityManager();

        $activite=$em->getRepository("AppBundle:Activite")
            ->findOneBy(['nom'=>$nom]);


        return $this->render('@App/Reservation/activite.html.twig',['rest'=>$activite]);
    }


    /**
     * @Route("/Reservation/activite/{id}",name="ReserverActivite")
     * @param $id
     */
    public function reserverActivite($id,Request $request){
        $user = $this->getUser();

        $reservation= new Reservation();
        $form= $this->createForm(\AppBundle\Form\ReservationType::class,$reservation);
        if($form->handleRequest($request)->isValid()){
            $em= $this->getDoctrine()->getManager();
            $activite=$em->getRepository("AppBundle:Activite")
                ->find($id);
            $reservation->setActvite($activite);
            $reservation->setUser($user);
            $em->persist($reservation);
            $em->flush();
            $this->addFlash('Success','Reservation bien pris en cours add');
            return $this->redirectToRoute("homepage");
        }
        return $this->render("@App/Reservation/reservactivite.html.twig",["form"=>$form->createView()]);

    }
}
