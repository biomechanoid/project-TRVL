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

        // $request = $this->container->get('request');
        // $session = $this->container->get('session');
        // if( !$session->has('_locale')) {
        //     $session->set('_locale', $request->getPreferredLanguage(array('en','sk')) );
        //     $request->setDefaultLocale($session->get('_locale'));
        // }

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
        if($category == '') {
            return $this->render('DJMainBundle:Main:gallery.html.twig', array('gallery'=>array()));
        }
        $em = $this->get('doctrine');

        $gallery = $this->get('doctrine')->getRepository('ApplicationSonataMediaBundle:Gallery');

        if(!$gallery->findOneByName($category)) {
            return $this->render('DJMainBundle:Main:gallery.html.twig', array('gallery'=>array()));
        }

        $galeryId = $gallery->findOneByName($category)->getId();
        $ghm = $this->get('doctrine')->getRepository('ApplicationSonataMediaBundle:GalleryHasMedia');
        $media= [];
        $typeAllowed = array(
                'images'=>array('jpg','jpeg','gif','png' ),
                'video' =>array('mp4','mp3','vlc','aac')
            );
        foreach($ghm->findByGallery(1) as $key=>$value) {
            $media[$key] = $value->getMedia();
            // foreach ($media as $key => $value) {
            if( in_array(strtolower(pathinfo($media[$key]->getName(), PATHINFO_EXTENSION)), $typeAllowed['images']) ) {
            $media[$key]->media_type = 'graphics';


            } elseif ( in_array(strtolower(pathinfo($media[$key]->getName(), PATHINFO_EXTENSION)), $typeAllowed['video']) ) {
            $media[$key]->media_type = 'video';

            } else {
            $media[$key]->media_type = 'mix';

            }
        }
        // var_dump($media[0]);
        // exit;
        return $this->render('DJMainBundle:Main:gallery.html.twig', array('gallery'=>$media));

    }

}
