<?php

namespace DJ\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DJ\BlogBundle\Entity\Post;
use DJ\BlogBundle\Entity\Category;

class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager) {
		$time = new \DateTime();
		$articles = [
				'F. Scott Fitzgerald'=>'1The Great Gatsby',
				'John Steinbeck'=>'2The Grapes of Wrath',
				'George Orwell'=>'Nineteen Eighty-Four',
				'James Joyce'=>'Ulysses',
				'Vladimir Nabokov'=>'Lolita',
				'Joseph Heller'=>'Catch-22',
				'J. D. Salinger'=>'The Catcher in the Rye',
				'Toni Morrison'=>'Beloved',
				'William Faulkner'=>'The Sound and the Fury',
				'Harper Lee'=>'To Kill a Mockingbird',
				'J. R. R. Tolkien'=>'The Lord of the Rings'
		];

		$category1 = new Category();
		$category1->setName('Brazil')
				 ->setParentCategory(0)
				 ->setDescription('Lorem ipsum dolor sit amet, consectetur.')
				 ->setSlug('brazil')
				 ->setDisplay(true);
		$manager->persist($category1);

		$category2 = new Category();
		$category2->setName('Argentina')
				->setParentCategory(0)
				->setDescription('Lorem ipsum dolor sit amet, consectetur.')
				->setSlug('argentina')
				->setDisplay(true);
		$manager->persist($category2);

		$category3 = new Category();
		$category3->setName('Peru')
				->setParentCategory(0)
				->setDescription('Lorem ipsum dolor sit amet, consectetur.')
				->setSlug('peru')
				->setDisplay(true);
		$manager->persist($category3);


		$iteration = 0;
		foreach ($articles as $author=>$title) {
			$iteration++;

			$article =  new Post();
			$article->setAuthor($this->getReference('admin'))
					->setTitle($title)
					->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore unde.')
					->setSlug(strtolower(str_replace(' ','', $title)))
					->setUpdated(new \DateTime('now'))
					->setNode(0)
					->setDisplay(true);
			if ($iteration % 2) {
				$article->setCategory($category2);
			} else {
				$article->setCategory($category1);
			}

			$manager->persist($article);
		}

		$manager->flush();
		$this->addReference('article',$article);

	}

	public function getOrder()
	{
		return 2;
	}
}