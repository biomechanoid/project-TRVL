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
				'F. Scott Fitzgerald'=>'#1The Great Gatsby',
				'John Steinbeck'=>'#2The Grapes of Wrath',
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
		$category1->setName('Main Category')
				 ->setParentCategory(0)
				 ->setDescription('Lorem ipsum dolor sit amet, consectetur.')
				 ->setSlug('main');

		$category2 = new Category();
		$category2->setName('My Books')
				->setParentCategory(0)
				->setDescription('Lorem ipsum dolor sit amet, consectetur.')
				->setSlug('my-books');

		$manager->persist($category1);
		$manager->persist($category2);
		$iteration = 0;
		foreach ($articles as $author=>$title) {
			$iteration++;

			$article =  new Post();
			$article->setAuthor($this->getReference('admin'))
					->setTitle($title)
					->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore unde.')
					->setSlug(strtolower(str_replace(' ','', $title)))
					->setUpdated(new \DateTime('now'))
					->setStatus('visible')
					->setNode(0);
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