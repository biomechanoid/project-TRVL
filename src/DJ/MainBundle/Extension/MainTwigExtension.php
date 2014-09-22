<?php

namespace DJ\MainBundle\Extension;

class MainTwigExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            'strip_tags' => new \Twig_Filter_Method($this, 'strip_tags'),

        );
    }
    public function strip_tags($string) {

        return str_replace('&nbsp;', '', \strip_tags($string) );
    }

    public function getName()
    {
        return 'main_twig_extension';
    }
}