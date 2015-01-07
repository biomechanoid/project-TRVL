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

        $galleryId = $galleryByCategory->getId();
        $media= [];
        $typeAllowed = array(
                'images'=>array('jpg','jpeg','gif','png' ),
                'video' =>array('mp4','mp3','vlc','aac')
            );

        foreach($ghm->findByGallery($galleryId) as $key=>$value) {
            if(!$value->getMedia()) {
                $media = array();
                break;
            }
            $media[$key] = $value->getMedia();

                $media[$key]->media_type = 'graphics';
            if( in_array(strtolower(pathinfo($media[$key]->getName(), PATHINFO_EXTENSION)), $typeAllowed['images']) ) {

            } elseif ( in_array(strtolower(pathinfo($media[$key]->getName(), PATHINFO_EXTENSION)), $typeAllowed['video']) ) {
                $media[$key]->media_type = 'video';

            } else {
                $media[$key]->media_type = 'mix';
            }
        }

        return $this->render('DJMainBundle:Main:gallery.html.twig', array('gallery'=>$media,
                                                                          'galleryName'=>$galleryByCategory->getName()
                                                                          ));
    }
}
