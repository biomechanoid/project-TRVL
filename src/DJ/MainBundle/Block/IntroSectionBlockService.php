<?php

namespace DJ\MainBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

class IntroSectionBlockService extends BaseBlockService
{

    public function getName()
    {
        return 'IntroSectionBlockService';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'title_style' => 'default',
            'title'    => 'denca &amp; kubo',
            'comment'  => false,
            'image_url'      => '/img/default/background.jpg',
            'video_url'      => 'https://www.youtube.com/watch?v=Lg7x1_2eJXQ',
            'video'    => false,
            'template' => 'DJMainBundle:Block:intro_section.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {

        return $this->renderResponse($blockContext->getTemplate(),
                                array('block' => $blockContext->getBlock(),
                                      'settings' => $blockContext->getSettings()
                                    ),
                                $response);
    }

}