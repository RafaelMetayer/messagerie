<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Use App\Entity\Groupe;

class MessageController extends AbstractController
{
    /**
    * @Route("/message/{id}", name="accueil")
    */
    public function index($id) {

        $repositoryG = $this -> getDoctrine() -> getRepository(Groupe::class);
        $repositoryM = $this -> getDoctrine() -> getRepository(Message::class);

        $groupes = $repositoryG -> findAll();
        $messages = $repositoryM -> findBy( ['groupe_id' => $id], ['date_time' => 'ASC']);

        return $this -> render("groupes/allConversations.html.twig", array('groupes'=>$groupes, 'messages'=>$messages));
    }
}
