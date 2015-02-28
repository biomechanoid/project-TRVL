<?php
namespace DJ\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller
{
    protected $assets;


    /**
     * @Route("/{_locale}{trailingSlash}", name="dj_route_home",requirements={"_locale"="%regions%", "trailingSlash" = "[/]{0,1}" }, defaults={"trailingSlash" = "/" })
     **/
    public function indexAction()
    {
        $categories = $this->get('doctrine')->getRepository('DJBlogBundle:Category')->findAllCategories(true);
        $pools = $this->get('doctrine')->getRepository('DJBlogBundle:Pool')
                                ->findByPath('index');
        $pool = [];
        $categoryList = $this->get('doctrine')->getRepository('DJBlogBundle:Category')
                                                            ->findAllCategories(true);

        foreach ($pools as $value) {
            if($value->getName() == 'index_primary_image') {
                $pool['primary'] = $value;
            } elseif($value->getName() == 'index_secondary_image') {
                $pool['secondary'] = $value;
            }
        }

        return $this->render('DJMainBundle:Main:index.html.twig', array('pool'=>$pool,'categories'=>$categoryList));
    }

    /**
     * @Route("/about/{_locale}", name="dj_main_aboutus", requirements={"_locale"="%regions%" }, defaults={"_locale" = "%locale%"} )
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

     /**
     * @Route("/gallery/{_locale}/{category}{trailingSlash}", name="dj_main_gallery", requirements={"_locale"="%regions%", "category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "_locale" = "%locale%", "trailingSlash" = "/" })
     *
     **/
    public function galleryAction($category)
    {
        $em = $this->get('doctrine');
        $gallery = $em->getRepository('ApplicationSonataMediaBundle:Gallery');
        $ghm = $em->getRepository('ApplicationSonataMediaBundle:GalleryHasMedia');

        if($category == '') {
          return $this->render('DJMainBundle:Main:gallery_index.html.twig');
        }

        $galleryByCategory = $gallery->findOneByName($category);

        if(!$galleryByCategory) {
            throw $this->createNotFoundException('Gallery with this category name does not exists!' . 'In class '. __class__ .'. On line ' . __line__ );
        }

        $parentGalleryId = $galleryByCategory->getId();
        $subgalleriesId = $galleryByCategory->getSubgalleriesId();
        array_unshift($subgalleriesId, $parentGalleryId);
        $media = [];
        $galleries = [];


        foreach($subgalleriesId as $galleryId) {

            foreach ($ghm->findByGallery($galleryId) as $key=>$value) {
                $media[] = array('media'=>$value->getMedia(),
                                 'name'=>$value->getGallery()->getName(),
                                 );
                $galleries[] =  $value->getGallery()->getName();
            }
        }

        return $this->render('DJMainBundle:Main:gallery.html.twig', array('gallery'=>$media,
                                                                          'gallery_list'=>array_values(array_unique($galleries,SORT_LOCALE_STRING)),
                                                                          'galleryName'=>$galleryByCategory->getName()
                                                                          ));
    }

     /**
     * @Route("/gallery/{category}{trailingSlash}", name="dj_main_gallery_category", requirements={"category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "_locale" = "%locale%", "trailingSlash" = "/" })
     **/
    public function galleryCategoryAction($category)
    {
      return $this->forward('DJMainBundle:Main:gallery',array('category'=>$category));
    }

}
