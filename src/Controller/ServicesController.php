<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Vendor;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $catrepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryRepository $catrepo)
    {
        $highlight = $catrepo->findOneBy([
            'highlight' => true
        ]);

        return $this->render('services_templates/index.html.twig',[
            'category' => $highlight
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function category(Category $category)
    {
        return $this->render('services_templates/category.html.twig',[
            'category' => $category
        ]);
    }

    /**
     * @Route("/vendor/{id}", name="vendor")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function vendor($id, Request $request, ObjectManager $manager)
    {
        $vendorrepo = $this->getDoctrine()->getRepository(Vendor::class);
        $vendor = $vendorrepo->find($id);

        $user = $this->getUser();

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setInternaut($user);
            $comment->setVendor($vendor);

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('vendor', ['id' => $id]);
        }

        return $this->render('services_templates/vendor.html.twig',[
            'vendor' => $vendor,
            'formComment' => $form->createView()
        ]);
    }
}