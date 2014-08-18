<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AssetAdmin extends Admin
{
	protected $translationDomain =  'DjPostTranslation';

	/**
	 * @param FormMapper $formMapper
	 */
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('dj.admin.asset.add.title.header',
				array('description' => 'Create new blog category'))
		->add('name', 'text', array('label'=>'dj.admin.asset.add.name.help') )
		->add('src','text', array('label'=>'dj.admin.asset.add.src.help'))
		->add('alt','text', array('label'=>'dj.admin.asset.add.alt.help'))
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
            ->add('src')
            ->add('alt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->add('src')
            ->add('alt')
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
            ->add('src')
            ->add('alt')
        ;
    }
}
