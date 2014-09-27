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
        $categoryRepository = $this->get('doctrine')->getRepository('DJBlogBundle:Category')
                                ->createQueryBuilder('c')->where('c.display= 1')->getQuery();
        $categoryEnity = $categoryRepository->getResult();
        if(!$categoryRepository) {
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
            if($this->getCategory($category) != null) {

            $this->assets['category'] = $this->getCategory($category);
            $this->assets['categories'] = $this->getCategories();
            $this->assets['category_posts'] = [];

            foreach ($this->getCategory($category)->getPosts() as $value) {
                if($value->getDisplay() == 1 ) {
                    $this->assets['category_posts'][] = $value;
                }
            }

            return array(
                     'category' => $this->assets['category'],
                     'categories' => $this->assets['categories'],
                     'posts'=> $this->assets['category_posts']
                     );

            } else {
                throw $this->createNotFoundException('Category does not exist!' . 'In class '. __class__ .'. On line ' . __line__ );

            }

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

         if($this->getCategory($category) != null) {
            $assets['post'] = false;
            $this->assets['category'] = $this->getCategory($category);
            $this->assets['categories'] = $this->getCategories();
            $this->assets['category_posts'] = [];

            foreach ($this->getCategory($category)->getPosts() as $value) {
                if($value->getSlug() == $post && $value->getDisplay() == true) {
                    $assets['post'] = true;
                    break;
                }
            }

            if($assets['post']) {
                return array(
                    'category' => $this->getCategory($category),
                    'categories' =>$this->getCategories(),
                    'post' => $value
                    );
            } else {
                throw $this->createNotFoundException('Post does not exists in category or is set as invisible!' . 'In class '. __class__ .'. On line ' . __line__ );
            }
        }
    }


    public function getCategory($category)
    {
        if ($category != '' ) {
            $categoryEnity = $this->get('doctrine')->getRepository('DJBlogBundle:Category')->createQueryBuilder('c');
            $categoryQuery = $categoryEnity->setParameter('category', $category)->where('c.slug = :category')->andHaving('c.display=1')->getQuery();

            if( $categoryQuery->getOneOrNullResult() == null ) {
                throw $this->createNotFoundException('Category does not exists in DB!');
            }

            return $categoryQuery->getOneOrNullResult();

        } else {
            throw $this->createNotFoundException('This category name is empty!' . 'In class '. __class__ .'. On line ' . __line__ );
        }
    }

    public function getCategories() {

        $categoryRepository = $this->get('doctrine')->getRepository('DJBlogBundle:Category')
                                ->createQueryBuilder('c')->having('c.display= 1')->getQuery();

        if( empty($categoryRepository->getResult()) ) {
            return array();
        } else {
            return $categoryRepository->getResult();
        }


    }


}
