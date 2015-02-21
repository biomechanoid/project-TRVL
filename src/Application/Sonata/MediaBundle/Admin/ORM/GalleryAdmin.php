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


class GalleryAdmin extends Admin
{
    protected $pool;

    /**
     * @param string                            $code
     * @param string                            $class
     * @param string                            $baseControllerName
     * @param \Sonata\MediaBundle\Provider\Pool $pool
     */
    public function __construct($code, $class, $baseControllerName, Pool $pool)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->tab('General')
                ->with($this->trans('Gallery'), array('class' => 'col-md-7'))->end()
                ->with($this->trans('Options'), array('class' => 'col-md-5'))->end()
                ->with($this->trans('Sub Galleries'), array('class' => 'col-md-7','collapsed'=>true ))->end()
            ->end()
            ->tab('Media')
                ->with($this->trans('Media'), array('class' => 'col-md-9'))->end()
            ->end()
        ;

        $context = $this->getPersistentParameter('context');

        if (!$context) {
            $context = $this->pool->getDefaultContext();
        }

        $formats = array();
        foreach ((array) $this->pool->getFormatNamesByContext($context) as $name => $options) {
            $formats[$name] = $name;
        }

        $contexts = array();
        foreach ((array) $this->pool->getContexts() as $contextItem => $format) {
            $contexts[$contextItem] = $contextItem;
        }

        $parentId = $this->subject->getId();
        $subjectId = $this->subject->getId();

        $subject = $this->getSubject();
        $subjectId = $subject->getId();

        $em = $this->modelManager->getEntityManager('Application\Sonata\MediaBundle\Entity\Gallery');
        $qb = $em->createQueryBuilder('p');

        $query = $em->createQuery(
                        'SELECT g
                         FROM ApplicationSonataMediaBundle:Gallery g
                         WHERE g.id = :subject')
                    ->setParameter('subject', $subjectId);

        $products = $query->getResult();

        $formMapper
            ->tab('General')
                ->with('Options')
                    ->add('context', 'hidden', array('data' => $contexts['gallery']))
                    ->add('defaultFormat', 'choice', array('choices' => $formats))
                    ->add('enabled', null, array('required' => false))
                ->end()
                ->with('Gallery')
                    ->add('name', 'text', array('attr'=>array('class'=>'gallery-name-form')))
                ->end()
                ->with('Sub Galleries')
                    ->add('subgalleries', 'sonata_type_collection',
                                array(
                                    'cascade_validation' => true,
                                    'by_reference'=>true

                                    ),
                                array(
                                    'edit'=>'inline',
                                    'inline'=>'table',
                                    'allow_delete' => true
                                      ))

                ->end()
            ->end()
            ->tab('Media')
                ->with('Media')
                    ->add('galleryHasMedias', 'sonata_type_collection', array(
                            'cascade_validation' => true,
                        ), array(
                            'edit'              => 'inline',
                            'inline'            => 'table',
                            'sortable'          => 'position',
                            'link_parameters'   => array('context' => $context),
                            'admin_code'        => 'sonata.media.admin.gallery_has_media'
                        )
                    )
                ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled', 'boolean', array('editable' => true))
            ->add('context', 'trans', array('catalogue' => 'SonataMediaBundle'))
            ->add('defaultFormat', 'trans', array('catalogue' => 'SonataMediaBundle'))
            ->add('parent')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('enabled')
            ->add('context')
            ->add('parent')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($gallery)
    {
        $parameters = $this->getPersistentParameters();

        $gallery->setContext($parameters['context']);

        // fix weird bug with setter object not being call
        $gallery->setGalleryHasMedias($gallery->getGalleryHasMedias());

        $gallery->setSubgalleries($gallery->getSubgalleries());
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($gallery)
    {
        // fix weird bug with setter object not being call
        $gallery->setGalleryHasMedias($gallery->getGalleryHasMedias());

        $gallery->setSubgalleries($gallery->getSubgalleries());
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistentParameters()
    {
        if (!$this->hasRequest()) {
            return array();
        }

        return array(
            'context'  => $this->getRequest()->get('context', $this->pool->getDefaultContext()),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getNewInstance()
    {
        $gallery = parent::getNewInstance();

        if ($this->hasRequest()) {
            $gallery->setContext($this->getRequest()->get('context'));
        }

        return $gallery;
    }


}
