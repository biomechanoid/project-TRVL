<?php
namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;


class CommentAdmin extends Admin
{
	protected $baseRouteName = 'admin_dj_comment';
	protected $baseRoutePattern = 'comment';
	protected $translationDomain =  'DjPostTranslation';

	// Fields to be shown on create/edit forms
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
		->with('dj.admin.comment.add.title.header',
				array('description' => 'Create new blog comment'))
		->add('created','datetime', array('disabled' =>true))
		->add('content', 'textarea', array(
				'trim'=>true,
				'label'=>'dj.admin.comment.add.content.help'))
		// ->add('post',  'sonata_type_admin', array('delete'=>false, 'btn_catalogue'=>false))
		->add('post', null, array('label'=>'dj.admin.comment.add.postid.help',
									 'disabled'=>true ))
		->add('user', 'entity', array(
				'class' => 'DJ\UserBundle\Entity\User',
				'expanded' => false,
				'disabled' =>true,
				'label' => 'dj.admin.comment.add.author.help'))
		->add('display','choice', array(
    			'choices'   => array(1 => 'Display', 0 => 'Hide'),
				'expanded'=>true,
				'label'=>'dj.admin.comment.add.checkbox.help'
				))

		->end()
		;
	}

	// Fields to be shown on filter forms
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
		->add('created','doctrine_orm_datetime', array('label'=>'dj.admin.comment.filter.created.help',
														'input_type'=>'timestamp'))
		->add('post', 'doctrine_orm_number', array('label'=>'dj.admin.comment.filter.post.help'))
		->add('user')
		->add('display')
		;
	}

	// Fields to be shown on lists
	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
		->addIdentifier('created')
		->add('content')
		->add('post.id')
		->add('user')
		->add('display')

		// add custom action links
		->add('_action', 'display', array(
				'actions' => array(
						'edit' => array(),
						'delete' => array()

				)
		))
		;
	}

	public function validationCategory(ErrorElement $errorElement, $object)
	{
 			$errorElement->with('content')
                ->assetNotInteger()
            ->end();
	}

}