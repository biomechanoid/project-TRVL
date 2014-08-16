<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


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
            ->add('content','textarea', array('help' => 'dj.admin.post.add.content.help'))
            ->add('slug', 'text', array('help' => 'dj.admin.post.add.slug.help'))
            ->end()
       ->with('dj.admin.post.add.resources.title.header')
//TODO: add other entities for managing blog resources
       	    ->end()
       ->with('dj.admin.post.add.settings.title.header')
            ->add('author', 'entity', array('class' => 'DJ\UserBundle\Entity\User', 'help' => 'dj.admin.post.add.author.help'))
            ->add('updated', 'datetime')

            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
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
        ;
    }

}