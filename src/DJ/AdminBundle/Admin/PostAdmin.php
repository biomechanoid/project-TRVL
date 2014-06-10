<?php

namespace DJ\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class PostAdmin extends Admin
{
    protected $baseROuteName = 'admin_dj_post';
    protected $baseRoutePattern = 'post';

     protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('new'); #Action gets added automaticly
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('dj.admin.post.add.general.title.header', array('description' => 'dj.admin.post.add.general.title.description'))
            ->add('title', 'text', array('label' => 'Post Title', 'help' => 'dj.admin.post.add.title.help'))
            ->add('author', 'entity', array('class' => 'DJ\UserBundle\Entity\User', 'help' => 'dj.admin.post.add.author.help'))
            ->add('content','text', array('label' => 'dj.admin.post.add.content.label', 'help' => 'dj.admin.post.add.content.help'))
            ->add('slug', 'text', array('label'=>'dj.admin.post.add.slug.label','help' => 'dj.admin.post.add.slug.help'))
            ->add('created','datetime')
            ->add('updated', 'datetime')
            ->end()
             //if no type is specified, SonataAdminBundle tries to guess it
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