<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Admin\ORM;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\MediaBundle\Provider\Pool;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Sonata\MediaBundle\Admin\BaseMediaAdmin as BaseMediaAdmin;

class MediaAdmin extends BaseMediaAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
         $listMapper
            ->addIdentifier('name')
            ->add('description')
            ->add('context')
            ->add('enabled')
            ->add('size')
        ;
    }

        protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('context')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {  parent::configureFormFields($formMapper);
        $formats = array();

        if($this->getSubject()->getContext() == 'gallery')
        {
            foreach ($this->pool->getContext('gallery')['formats'] as $key => $format) {
                $formats[str_replace('gallery_','',$key)] = $key;
            }

            $formMapper->add('format','choice',array('choices'=> $formats));

        }
    }

}