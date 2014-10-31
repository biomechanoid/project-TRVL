<?php

namespace DJ\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
    * @return if no result emty array()
    *         else array of object DJ\BlogBundle\Entity\Category
    **/
    public function findAllCategories($returnSmallArray = false) {
        $em = $this->getEntityManager();
        if (!$returnSmallArray) {
            $categoryQuery = $em->createQuery('SELECT c FROM DJBlogBundle:Category c JOIN c.media m WHERE c.display=:display')
                            ->setParameter('display',1);
        } else {
            $categoryQuery = $em->createQuery('SELECT c.name, c.slug FROM DJBlogBundle:Category c JOIN c.media m WHERE c.display=:display')
                            ->setParameter('display',1);
        }


        return $categoryQuery->getResult();
    }


    public function findCategoryBySlug($slug, $returnSmallArray = false) {
        $em = $this->getEntityManager();
        if(!$returnSmallArray) {
            $categoryQuery = $em->createQuery('SELECT c.slug, c.name FROM DJBlogBundle:Category c WHERE c.slug = :slug')
                            ->setParameter('slug', $slug);
        } else {
            $categoryQuery = $em->createQuery('SELECT c FROM DJBlogBundle:Category c WHERE c.slug = :slug')
                            ->setParameter('slug', $slug);
        }


        return $categoryQuery->getOneOrNullResult();
    }


    public function findPostsFromCategory(Category $category, $locale = '', $returnPaginatorFormat = false) {

        if($locale == '') {
            $locale = 'en';
        }
        $em = $this->getEntityManager();
        $category_posts = [];

        if($returnPaginatorFormat) {
            $post = $em->createQuery('SELECT p.id, p.title, p.slug FROM DJBlogBundle:Post p WHERE p.category = :categoryId AND p.display=:display AND p.locale = :locale');
            $post->setParameters(
                        array(
                            'categoryId' => $category->getId(),
                            'locale' => $locale,
                            'display' => 1
                        ));

        foreach ($post->getArrayResult() as $localKey=>$localPost) {
            $category_posts[++$localKey] = array(
                                                'id'=>  $localKey,
                                                'real_id'=>$localPost['id'],
                                                'name'=>$localPost['title'],
                                                'slug'=>$localPost['slug']
                                                 );
        }

        return $category_posts;

        }else {
            $post = $em->createQuery('SELECT p FROM DJBlogBundle:Post p WHERE p.category = :categoryId AND p.display=:display AND p.locale = :locale');
            $post->setParameters(
                        array(
                            'categoryId' => $category->getId(),
                            'locale' => $locale,
                            'display' =>1
                        ));
        }

        return $post->getResult();

    }


    public function findOnePostFromCategory( Category $category, $post_slug, $locale='' ) {
        if($locale == '') {
            $locale = 'en';
        }

        $em = $this->getEntityManager();

        $post = $em->createQuery('SELECT p FROM DJBlogBundle:Post p WHERE p.category = :categoryId AND p.slug = :postSlug AND p.display=:display AND p.locale = :locale');
        $post->setParameters(
                    array(
                        'categoryId' => $category->getId(),
                        'postSlug' => $post_slug,
                        'locale' => $locale,
                        'display' =>1
                    ));


        return $post->getOneOrNullResult();

    }
}
