<?php
namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;


class CategoryAdmin extends Admin
{
	protected $baseRouteName = 'admin_dj_category';
	protected $baseRoutePattern = 'category';
	protected $translationDomain =  'DjPostTranslation';

	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('dj.admin.category.add.title.header',
				array('description' => 'Create new blog category'))
			->add('name', 'text', array('help' => 'dj.admin.category.add.name.help'))
			->add('slug', 'text', array('help' => 'dj.admin.category.add.slug.help'))
			->add('description', 'text', array('help' => 'dj.admin.category.add.description.help') )

		->end()
		;
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('name')
		->add('slug')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('name', 'text')
		->add('description', 'text')
		->addIdentifier('slug', 'text')

		;
	}

	public function validationCategory(ErrorElement $errorElement, $object)
	{
 			$errorElement->with('name')
                ->assertType(array('type'=>'string',
                                   'message'=>'dj.admin.category.add.text.error'))
                ->assertNotBlank()
            ->end();
            $errorElement->with('slug')
                ->assertType(array('type'=>'string',
                                   'message'=>'dj.admin.category.add.slug.error'))
                ->assertNotBlank()
                ->assertNotNull()
            ->end();
            $errorElement->with('description')
                ->assertType(array('type'=>'alnum',
                                   'message'=>'dj.admin.category.add.description.error'))
            ->end();
	}

}