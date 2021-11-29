<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface {
	public const CATEGORY_GRABS_REFERENCE = "category-grabs";

	public function __construct() {}

	public function getOrder() {
		return 2;
	}

	public function load(ObjectManager $manager) {
		$category = new Category();
		$category->setName("Grabs");
		$this->addReference(self::CATEGORY_GRABS_REFERENCE, $category);
		$manager->persist($category);

		$category = new Category();
		$category->setName("Slides");
		$manager->persist($category);

		$manager->flush();
	}
}
