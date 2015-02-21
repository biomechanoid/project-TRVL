<?php
namespace DJ\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MainController extends Controller
{
    protected $assets;


    /**
     * @Route("/{_locale}{trailingSlash}", name="dj_route_home",requirements={"_locale"="|en|sk", "trailingSlash" = "[/]{0,1}" }, defaults={"trailingSlash" = "/" })
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
     * @Route("/{_locale}/about", name="dj_main_aboutus", requirements={"_locale"="|en|sk" } )
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/gallery{trailingSlash}{category}", name="dj_main_gallery", requirements={"_locale"="|en|sk", "category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "trailingSlash" = "/" })
     **/
    public function galleryAction($category)
    {
        $em = $this->get('doctrine');
        $gallery = $em->getRepository('ApplicationSonataMediaBundle:Gallery');
        $ghm = $em->getRepository('ApplicationSonataMediaBundle:GalleryHasMedia');

        if($category == '') {
            $galleriesQuery = $gallery->createQueryBuilder('g')->where('g.enabled = 1')->getQuery();
            $galleries = $galleriesQuery->getResult();

            return $this->render('DJMainBundle:Main:gallery_index.html.twig', array('galleries'=>$galleries));
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
     * @Route("/gallery{trailingSlash}{category}", name="dj_main_gallery_category", requirements={"category" = "[a-zA-Z0-9-_]+", "trailingSlash" = "[/]{0,1}"}, defaults={"category" = null, "trailingSlash" = "/" })
     **/
    public function galleryCategoryAction($category)
    {
        return $this->redirect($this->generateUrl('dj_main_gallery', array('category'=>$category)), 301);
    }

}
