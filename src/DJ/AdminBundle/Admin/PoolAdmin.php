<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

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
		->add('type', 'choice', array('label'=>'dj.admin.pool.add.type.help',
                    'choices'=>array('image'=>'image', 'video'=>'video','other'=>'other'),
                    'required'=>true,
                    'expanded'=>true,
                    'data'=>'image'))
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

    public function validationCategory(ErrorElement $errorElement, $object)
    {
        $errorElement->with('name')
            ->assertType(array('type'=>'string',
                               'message'=>'dj.admin.pool.add.name.error'))
            ->assertNotBlank()
        ->end();
        $errorElement->with('description')
                ->assertType(array('type'=>'alnum',
                                   'message'=>'dj.admin.pool.add.description.error'))
            ->end();
        $errorElement->with('type')
            ->assertType(array('type'=>'alnum',
                               'message'=>'dj.admin.pool.add.description.error',
                               'value'=>'image'))
        ->end();


    }
}
