<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Application\Sonata\MediaBundle\Admin\ORM\GalleryAdmin;
use Sonata\MediaBundle\Provider\Pool;
use Sonata\MediaBundle\Form\DataTransformer\ProviderDataTransformer;
use Sonata\AdminBundle\Route\RouteCollection;

class SubGalleryAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        // $datagridMapper
        //     ->add('parent_id')

        // ;
    }

    /**
     * @param FormMapper $formMapper
     */
        protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->with($this->trans('Parent Gallery'), array('class' => 'col-md-12'))->end()
            ->with($this->trans('Add Childrens'), array('class' => 'col-md-6'))->end()
        ;

        $subject = $this->getSubject();
        $em = $this->modelManager->getEntityManager('Application\Sonata\MediaBundle\Entity\Gallery');

        $formMapper
            ->with('Parent Gallery')
                ->add('parentGallery', 'entity',array(
                                          'label' => 'Parent Gallery',
                                          'attr'=>array('class'=>'gallery-parent-form'),
                                          'required'=>true,
                                          'class' => 'Application\Sonata\MediaBundle\Entity\Gallery',
                                          'query_builder' => function($em) {
                                                        $qb = $em->createQueryBuilder('p');
                                                        $qb->where('p.id IS NOT NULL');


                                                        return $qb;
                                            }
                    ))
            ->end()
            ->with('Add Childrens')
                ->add('childrenGallery', 'entity', array('label' => 'Child Gallery',
                                          'required'=>true,
                                          'class' => 'Application\Sonata\MediaBundle\Entity\Gallery',
                                          'query_builder' => function($em) {
                                                        $qb = $em->createQueryBuilder('c');
                                                        $qb->where('c.id IS NOT NULL');

                                                        return $qb;
                                            }
                    ))
                ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    // protected function configureShowFields(ShowMapper $showMapper)
    // {
    //     $showMapper
    //         ->add('id')
    //     ;
    // }
}
