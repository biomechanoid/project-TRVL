<?php
namespace DJ\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DJ\BlogBundle\Entity\Comment;
use DJ\BlogBundle\Entity\Post;
use DJ\BlogBundle\Entity\Asset;
use DJ\BlogBundle\Entity\Pool;
use DJ\BlogBundle\Entity\PostAsset;

class LoadPostsAssetsData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager) {

		$pool1 = new Pool();
		$pool1->setName('primary_image')
		     ->setDescription('primary backgound image on landing page')
		     ->setPath('index')
		     ;
		$manager->persist($pool1);

		$pool2 = new Pool();
		$pool2->setName('secondary_image')
		->setDescription('main image pool on the blog post')
		->setPath('index')
		;
		$manager->persist($pool2);

		$asset1 = new Asset();
		$asset1->setName('cool image')
			  ->setAlt('My best image')
			  ->setSrc('/foo/bar/image.jpg')
			  ;
		$manager->persist($asset1);

		$asset2 = new Asset();
		$asset2->setName('cool video')
			   ->setAlt('My best video')
		       ->setSrc('/foo/bar/video.vlc')
		;
		$manager->persist($asset2);

		$post1 = $manager->getRepository('DJBlogBundle:Post')->findOneBy(array('title'=>'The Lord of the Rings'));
		$post2 = $manager->getRepository('DJBlogBundle:Post')->findOneBy(array('title'=>'Beloved'));

// var_dump($post);exit;

		$pa1 = new PostAsset();
		$pa1->setPoolid($pool1)
		   ->setAssetid($asset1)
		   ->setPostid($post1)
		;
		$manager->persist($pa1);

		$pa2 = new PostAsset();
		$pa2->setPoolid($pool2)
		->setAssetid($asset1)
		->setPostid($post2)
		;
		$manager->persist($pa2);



		$manager->flush();

	}

	public function getOrder()
	{
		return 4;
	}
}