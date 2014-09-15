<?php

namespace DJ\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class BlogController extends Controller
{
    protected $assets = array();


    /**
     * @Route("/", name="dj_blog_main")
     * @Template("DJMainBundle:Blog:blog_index.html.twig")
     */
    public function indexAction()
    {
        $categoryEnity = $this->get('doctrine')->getRepository('DJBlogBundle:Category')->findAll() ;
        if(!$categoryEnity) {
            return array('categories' => array());
        }
        $all_categories = [];
        foreach ($categoryEnity as $category) {
            $all_categories[] = $category;
        }

        return array('categories' => $all_categories);
    }

    /**
     * @Route("/{category}{trailingSlash}", name="blog_category", requirements={"category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "trailingSlash" = "/" })
     * @Template("DJMainBundle:Blog:blog_category.html.twig")
     */
    public function categoryAction($category)
    {
        $this->assets['category'] = $this->getCategory($category)['categoryName'];
        $this->assets['categories'] = $this->getCategory($category)['all_categories'];
        $this->assets['category_posts'] = $this->assets['category']->getPosts();
        $this->assets['category_posts'] = [];
        foreach ($this->assets['category']->getPosts() as $value) {
            if($value->getStatus() == 'visible' ) {
                $this->assets['category_posts'][] = $value;
            }
        }

        return array(
                     'category' => $this->assets['category'],
                     'categories' => $this->assets['categories'],
                     'posts'=> $this->assets['category_posts']
                     );
        // $response = $this->render('DJBlogBundle:Blog:category.html.twig', array('category' => $this->assets['category'],
        //              'posts'=>$assets['category_post']));
        // $response->setMaxAge(600);
        // $response->setPublic();

        // return $response;
    }

    /**
     * @Route("/{category}/{post}", name="blog_post", requirements={"category" = "[a-zA-Z0-9-_]+","post" = "[a-zA-Z0-9-_]+"}, defaults={"category" = null})
     * @Template("DJMainBundle:Blog:blog_post.html.twig")
     */
    public function postAction($category, $post)
    {
        $this->assets['category'] = $this->getCategory($category)['categoryName'];
        $this->assets['categories'] = $this->getCategory($category)['all_categories'];

        $post = (string)trim(strtolower($post));
        $assets['post'] = [];

        foreach ($this->assets['category']->getPosts() as $value) {
            if($value->getSlug() == $post) {
                return array(
                            'category' => $this->assets['category'],
                            'categories' => $this->assets['categories'],
                            'post' => $value
                            );
            } else {
                continue;
            }
        }
        throw $this->createNotFoundException('No article "' . $post . '" in category with id = '.$assets['category']->getId());

    }

    public function getCategory($category)
    {
        if ($category != '' ) {
            $categoryEnity = $this->get('doctrine')->getRepository('DJBlogBundle:Category');
            if(!$categoryEnity) {
                $this->createNotFoundException('Category does not exists in DB!');
            }
            $all_categories = [];
            foreach ($categoryEnity->findAll() as $value) {
                $all_categories[] = $value;
            }

            return array('categoryName' => $categoryEnity->findOneBySlug($category),
                         'all_categories' => $all_categories);

        } else {
            throw $this->createNotFoundException('This category does not exist!');
        }
    }


}