<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {
	/**
	  * @Route("/")
	  * @method({"GET"}) 
	*/

	public function index(){
        // return new Response('<html><body></body>Hello</html>');

        $articles = ['article1', 'article2', 'article3'];
        return $this->render('article/index.html.twig', array('articles'=>$articles));
	}
}