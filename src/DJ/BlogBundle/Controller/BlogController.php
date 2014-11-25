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
        $all_categories = $this->get('doctrine')->getRepository('DJBlogBundle:Category')
                                                ->findAllCategories();
        $pools = $this->get('doctrine')->getRepository('DJBlogBundle:Pool')->findByPath('blog');
        $pool = [];
        foreach ($pools as $value) {
            if($value->getName() == 'blog_primary_image') {
                $pool['primary'] = $value;
            }
        }

        return array('categories' => $all_categories,'pool'=>$pool);
    }

    /**
     * @Route("/{category}{trailingSlash}", name="blog_category", requirements={"category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "trailingSlash" = "/" })
     * @Template("DJMainBundle:Blog:blog_category.html.twig")
     */
    public function categoryAction($category)
    {
        $categoryRepository = $this->get('doctrine')->getRepository('DJBlogBundle:Category');
        $categoryObject = $categoryRepository->findOneBySlug($category);

        if($categoryRepository->findCategoryBySlug($category) ) {
            $this->assets['category']['category'] = $categoryRepository->findCategoryBySlug($category);
            $this->assets['category']['categories'] = $categoryRepository->findAllCategories(true);
            $this->assets['category']['posts'] = $categoryRepository->findPostsFromCategory($categoryObject, $this->get('request')->getLocale());


        return $this->assets['category'];

        } else {
            throw $this->createNotFoundException('Category does not exist!' . 'In class '. __class__ .'. On line ' . __line__ );

        }

    }

    /**
     * @Route("/{category}/{post}", name="blog_post", requirements={"category" = "[a-zA-Z0-9-_]+","post" = "[a-zA-Z0-9-_]+"}, defaults={"category" = null})
     * @Template("DJMainBundle:Blog:blog_post.html.twig")
     */
    public function postAction($category, $post)
    {
        $categoryRepository = $this->get('doctrine')->getRepository('DJBlogBundle:Category');
        $categoryObject = $categoryRepository->findOneBySlug($category);
        $this->assets['post'] = $categoryRepository->findOnePostFromCategory( $categoryObject,
                                                                              $post,
                                                                              $this->get('request')->getLocale()
                                                                            );

         if($this->assets['post']) {
            $this->assets['post_categories'] = $categoryRepository->findAllCategories(true);
            $this->assets['post_category'] = $categoryRepository->findCategoryBySlug($category, true);
            $this->assets['post_list'] = $categoryRepository->findPostsFromCategory($categoryObject,
                                                                                    $this->get('request')->getLocale(),
                                                                                    true
                                                                                    );

        return array(
            'category' => $this->assets['post_category'],
            'categories' =>$this->assets['post_categories'],
            'posts' => $this->assets['post_list'],
            'post' => $this->assets['post']
            );
        } else {
            throw $this->createNotFoundException('Post does not exists in category or is set as invisible!' . 'In class '. __class__ .'. On line ' . __line__ );
        }
    }

}
