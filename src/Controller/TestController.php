<?php
// src/Controller/ChatController.php
namespace App\Controller;

use App\Classes\DataUserSession;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function test(Request $request, HubInterface $hub, DataUserSession $dataUserSession): Response
    {
        $form = $this->createFormBuilder()
            ->add('destinataire', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('message', TextType::class, ['attr' => ['autocomplete' => 'off']])
            ->add('send', SubmitType::class)
            ->getForm();

        $emptyForm = clone $form; // Used to display an empty form after a POST request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // 🔥 The magic happens here! 🔥
            // The HTML update is pushed to the client using Mercure
            $hub->publish(new Update(
                'test/'.$data['destinataire']->getId(),
                $this->renderView('test/message.stream.html.twig', [
                    'message' => $data['message'],
                    'user' => $this->getUser()
                ]),
                false
            ));

            $hub->publish(new Update(
                'test/'.$this->getUser()->getId(),
                $this->renderView('test/message.stream.html.twig', [
                    'message' => $data['message'],
                    'user' => $this->getUser()
                ]),
                false
            ));

            // Force an empty form to be rendered below
            // It will replace the content of the Turbo Frame after a post
            $form = $emptyForm;
        }


        return $this->render('test/index.html.twig', [
            'form' => $form,
        ]);
    }
}
