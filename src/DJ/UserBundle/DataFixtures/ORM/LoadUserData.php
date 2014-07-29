<?php

namespace DJ\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DJ\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager) {

		$userAdmin = new User();
		$userAdmin->setUsername('jakub')
				  ->setPassword('jakub')
				  ->setEmail('jakub@jakub.com');

		$manager->persist($userAdmin);
		$manager->flush();
	}

	public function getOrder()
	{
		return 1;
	}
}