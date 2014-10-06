<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;


class PostAdmin extends Admin
{
    protected $baseRouteName = 'admin_dj_post';
    protected $baseRoutePattern = 'post';
    protected $translationDomain =  'DjPostTranslation';


     protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('new'); #Action gets added automaticly
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
        ->with('dj.admin.post.add.blog.title.header', array('description' => 'Manage your blog content'))
            ->add('title', 'text', array('help' => 'dj.admin.post.add.title.help'))
            ->add('content','textarea', array('help' => 'dj.admin.post.add.content.help', 'attr'=>array('class'=>'ckeditor')))
            ->add('slug', 'text', array('help' => 'dj.admin.post.add.slug.help'))
            ->add('locale', 'choice', array(
                            'label' => 'dj.admin.post.add.locale.help',
                            'choices'=>array('en'=>'en', 'sk'=>'sk'),
                            'required'=>true
                            ))
            ->end()
            ->add('display', 'choice', array(
            		'label'=>'dj.admin.post.add.blog.status.header',
            		'choices'=>array(true=>'visible', false=>'hidden'),
            		'required'=>true,
            		'expanded'=>true
            ))
            ->end()
       ->with('dj.admin.post.add.category.title.header')
			->add('category', 'sonata_type_model', array())
       	    ->end()
       ->with('dj.admin.post.add.assets.title.header')
       	// 	->add('postAssets', 'sonata_type_collection',
       	// 			array(),
       	// 			array('admin_code'=>'dj_admin.admin.post_asset')
        // )
//        ->add('media', 'sonata_media_type', array(
//                     'provider' => 'sonata.media.provider.image',
//                     'context'  => 'blog',
//                     'empty_on_new' => false
// ))
        ->add('media', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'blog')))


       	    ->end()
       ->with('dj.admin.post.add.settings.title.header')
            ->add('author', 'entity', array('class' => 'DJ\UserBundle\Entity\User', 'help' => 'dj.admin.post.add.author.help'))
//             ->add('created')
            ->add('softDelete','checkbox', array(
            		'required'=>false
				))
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
            ->add('locale')
            ->add('display')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('content','text', array('label' => 'Post Content'))
            ->add('slug', 'url')
            ->add('author', 'text')
            ->add('locale', 'text')
            ->add('display', 'choice')
             ->add('media')
        ;
    }

    public function validationCategory(ErrorElement $errorElement, $object)
    {
            $errorElement->with('title')
                ->assertType(array('type'=>'string',
                                   'message'=>'dj.admin.post.add.title.error'))
                ->assertNotBlank()
            ->end();
            $errorElement->with('content')
                ->assertNotBlank()
                ->assertNotNull()
            ->end();
            $errorElement->with('slug')
                ->assertType(array('type'=>'string',
                                   'message'=>'dj.admin.post.add.slug.error'))
                ->assertRegex(array('pattern' => '/[a-zA-Z0-9-_]+/', 'match' => true, 'message' => 'Only -, _, 0-9, a-Z characters are valid'))
                ->assertNotBlank()
                ->assertNotNull()
            ->end();
    }

}