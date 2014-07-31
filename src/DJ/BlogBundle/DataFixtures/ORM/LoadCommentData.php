<?php

namespace DJ\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DJ\BlogBundle\Entity\Comment;
use DJ\BlogBundle\Entity\Post;
use DJ\UserBundle\Entity\User;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager) {


		for($i=0; $i<10; $i++) {
			$comment1 = new Comment();
			$comment1->setPost($this->getReference('article'))
			->setUserid($this->getReference('admin'))
			->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure nam maxime consectetur.')
			->setDisplay(1)
			->setIp('101.110.111.111')
			;
			$manager->persist($comment1);
		}
		$manager->flush();

	}

	public function getOrder()
	{
		return 3;
	}
}