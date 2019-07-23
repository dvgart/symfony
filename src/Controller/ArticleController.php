<?php 

namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends Controller {

	/**
	 * @Route("/", name="article_list")
	 * @method({"GET"})
	 */

	public function index(){
       
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', array('articles' => $articles));
	}


	/**
	 * @Route("/article/delete/{id}")
	 * @Method({"DELETE"})
	 */
    
    public function delete(Request $request, $id){
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


	/**
	 * @Route("/article/save")
	 *
	 */

	public function save(){
       $entityManager = $this->getDoctrine()->getManager();

       $article = new Article();
       $article->setTitle('Article 2');
       $article->setBody('This is body for atricle two');

       $entityManager->persist($article);
       $entityManager->flush();

       return new Response('Saves an article with the id of '.$article->getId());
	}


	/**
	 * @Route("/article/edit/{id}", name="edit_article")
	 * 
	 */

    public function edit(Request $request, $id){

    	$article = new Article();
    	$article = $this->getDoctrine()->getRepository(Article::class)->find($id);

	    $form = $this->createFormBuilder($article)
	        ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
	        ->add('body', TextareaType::class, [
	        	'attr' => ['class' => 'form-control', 'required' => false],
	        ]) 
	        ->add('save', SubmitType::class, [
	        	'label' => 'Edit article',
	        	'attr' => ['class' => 'btn btn-primary mt-3']
	        ])
	        ->getForm();

	    $form->handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()){
	        // $form->getData() holds the submitted values
	        // but, the original `$task` variable has also been updated
	        $article = $form->getData();

	        // ... perform some action, such as saving the task to the database
	        // for example, if Task is a Doctrine entity, save it!
	        $entityManager = $this->getDoctrine()->getManager();
	        $entityManager->flush();

	        return $this->redirectToRoute('article_list');
	    }

	        return $this->render('/article/edit.html.twig', array(
	        	'form' => $form->createView()
	        ));     
    }


	/**
	 * @Route("/article/new", name="new_article")
	 * 
	 */

    public function new(Request $request){

    	$article = new Article();

	    $form = $this->createFormBuilder($article)
	        ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
	        ->add('body', TextareaType::class, [
	        	'attr' => ['class' => 'form-control', 'required' => false],
	        ]) 
	        ->add('save', SubmitType::class, [
	        	'label' => 'Create Task',
	        	'attr' => ['class' => 'btn btn-primary mt-3']
	        ])
	        ->getForm();

	    $form->handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()){
	        // $form->getData() holds the submitted values
	        // but, the original `$task` variable has also been updated
	        $article = $form->getData();

	        // ... perform some action, such as saving the task to the database
	        // for example, if Task is a Doctrine entity, save it!
	        $entityManager = $this->getDoctrine()->getManager();
	        $entityManager->persist($article);
	        $entityManager->flush();

	        return $this->redirectToRoute('article_list');
	    }

	        return $this->render('/article/new.html.twig', array(
	        	'form' => $form->createView()
	        ));     
    }


    /**
	 * @Route("/article/{id}", name="article_show")
	 *
	 */

    public function show($id){
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('article/show.html.twig', array('article' => $article));
    }

}