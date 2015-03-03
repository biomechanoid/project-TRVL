<?php

namespace DJ\MainBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

class GallerySectionBlockService extends BaseBlockService
{

    protected $em;

    public function __construct($type, $templating, $em)
    {
        $this->type = $type;
        $this->templating = $templating;
        $this->em = $em;
    }

    public function getName()
    {
        return 'GallerySection';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url'      => false,
            'title'    => 'gallery',
            'template' => 'DJMainBundle:Block:gallery_section_list.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $gallery = $this->em->getRepository('ApplicationSonataMediaBundle:Gallery');
        $galleries = $gallery->getAllMainGalleries();

        return $this->renderResponse($blockContext->getTemplate(),
                                array('block' => $blockContext->getBlock(),
                                      'settings' => $blockContext->getSettings(),
                                      'galleries'=>$galleries
                                    ),
                                $response);
    }

}