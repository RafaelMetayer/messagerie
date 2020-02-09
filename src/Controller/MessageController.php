<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

Use App\Entity\Groupe;
Use App\Entity\Message;
use App\Form\SendMessageType;

class MessageController extends AbstractController
{
    /**  
    * @Route("/message/{id}", name="message")
    */

    public function addMessage(Request $request, $id){

        $repository = $this -> getDoctrine() -> getRepository(Groupe::class);

        $Allgroupes = $repository -> findAll();
        $MessageGroupes = $repository -> find($id);

        $manager = $this -> getDoctrine() -> getManager();
        $message = new Message;

        $form = $this -> createForm(SendMessageType::class, $message);
        $form->handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()){
            $manager -> persist($message);
            $message -> setDateTime(new \DateTime('now'));
            $message -> setUser($this->getUser());
            $message -> setGroupe($MessageGroupes);
            $message -> setState(1);
            $manager -> flush();

            return $this -> redirectToRoute('groupe');
        }
        return $this -> render('groupes/allConversations.html.twig', ['groupes'=>$Allgroupes, 'messages'=> $MessageGroupes -> getMessages(), 'utilisateurs' => $MessageGroupes -> getUsers(), 'groupeInfo'=> $MessageGroupes, 'messageForm' =>$form->createView()]);
    }

    /**  
    * @Route("/message", name="groupe")
    */

    public function allGroups(){

        $repository = $this -> getDoctrine() -> getRepository(Groupe::class);

        $Allgroupes = $repository -> findAll();

        return $this -> render('groupes/allGroups.html.twig', ['groupes'=>$Allgroupes]);
    }

}
