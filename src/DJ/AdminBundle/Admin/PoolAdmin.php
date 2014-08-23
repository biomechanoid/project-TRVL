<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PoolAdmin extends Admin
{
	protected $translationDomain =  'DjPostTranslation';

	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('dj.admin.pool.add.title.header',
				array('description' => 'Pool is the place where images and videos will be placed'))
		->add('id', 'text', array('disabled'=>true,'label'=>'dj.admin.pool.add.id.help'))
		->add('name', 'text', array('trim'=>true, 'label'=>'dj.admin.pool.add.name.help'))
		->add('description', 'text', array('trim'=>true, 'label'=>'dj.admin.pool.add.description.help'))
		->add('type', 'text', array('trim'=>true, 'label'=>'dj.admin.pool.add.type.help'))
		;
	}

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('type')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('name')
            ->add('description')
            ->add('type')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('type')
        ;
    }
}
