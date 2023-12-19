<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(Request $request, HubInterface $hub): Response
    {
        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['attr' => ['autocomplete' => 'off']])
//            ->add('body', TextType::class, ['attr' => ['autocomplete' => 'off']])
            ->add('send', SubmitType::class)
            ->getForm();

        $emptyForm = clone $form; // Used to display an empty form after a POST request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // 🔥 The magic happens here! 🔥
            // The HTML update is pushed to the client using Mercure
            $hub->publish(new Update(
                'post',
                $this->renderView('blog/post.stream.html.twig', [
                    'title' => $data['title'],
//                    'body' => $data['body'],
                ]),
                false
            ));
            $form = $emptyForm;
        }

        return $this->render('blog/index.html.twig', [
            'form' => $form,
        ]);
    }
}
