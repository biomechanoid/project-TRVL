<?php

namespace DJ\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class BlogController extends Controller
{
    protected $assets = array();


    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/{category}{trailingSlash}", requirements={"category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "trailingSlash" = "/" })
     * @Template()
     */
    public function categoryAction($category)
    {
        $this->assets['category'] = $this->getCategory($category);
        $assets['category_post'] = $this->assets['category']->getPosts();

        return array(
                     'category' => $this->assets['category'],
                     'posts'=>$assets['category_post']
                     );
        // $response = $this->render('DJBlogBundle:Blog:category.html.twig', array('category' => $this->assets['category'],
        //              'posts'=>$assets['category_post']));
        // $response->setMaxAge(600);
        // $response->setPublic();

        // return $response;
    }

    /**
     * @Route("/{category}/{post}", requirements={"category" = "[a-zA-Z0-9-_]+","post" = "[a-zA-Z0-9-_]+"}, defaults={"category" = null})
     * @Template()
     */
    public function postAction($category, $post)
    {
        $this->assets['category'] = $this->getCategory($category);

        $post = (string)trim(strtolower($post));
        $assets['post'] = [];

        foreach ($this->assets['category']->getPosts() as $value) {

            if($value->getSlug() == $post) {
                return array('category' => $this->assets['category'], 'post'=>$value);
            } else {
                continue;
            }
        }
        throw $this->createNotFoundException('No article "' . $post . '" in category with id = '.$assets['category']->getId());

    }

    public function getCategory($category)
    {
        if ($category != '' ) {
            return $this->get('doctrine')->getRepository('DJBlogBundle:Category')
                                                    ->findOneBySlug($category);
            if(!$category) {
                $this->createNotFoundException('Category does not exists in DB!');
            }

        } else {
            throw $this->createNotFoundException('This category does not exist!');
        }
    }
}
