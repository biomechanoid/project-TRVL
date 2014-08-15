<?php
namespace DJ\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DJ\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function load(ObjectManager $manager) {

		$userManager = $this->container->get('fos_user.user_manager');
		$user = $userManager->createUser();
		$user->setUsername('jakub')
			 ->setPassword('jakub')
			 ->setEmail('jakub@jakub.com');

		$manager->persist($user);
		$manager->flush();

		$this->addReference('admin',$user);
	}

	public function getOrder()
	{
		return 1;
	}
}