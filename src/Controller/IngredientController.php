<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * This function displays all ingredients
     *
     * @param IngredientRepository $IngredientRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'app_ingredient',methods:['GET'])]
    public function index(IngredientRepository $IngredientRepository, PaginatorInterface $paginator, Request $request): Response 
    {
        $ingredients = $paginator->paginate(
            $IngredientRepository->findAll(),
            $request->query->getInt('page',1),
            10
        );

      
        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients'=>$ingredients
        ]);
    }

    #[Route('/ingredient/nouveau', name:'app_ingredient_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager):Response{
        
        $ingredient= new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            return $this->redirectToRoute('app_ingredient');
            
        }


        return $this->render('pages/ingredient/new.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
