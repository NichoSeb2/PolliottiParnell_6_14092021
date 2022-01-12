<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public const CATEGORY_GRABS_REFERENCE = "category-grabs";
	public const CATEGORY_FLIPS_REFERENCE = "category-flips";
	public const CATEGORY_ROTATIONS_REFERENCE = "category-rotations";
	public const CATEGORY_SLIDES_REFERENCE = "category-slides";

	public function __construct() {}

	public function getOrder() {
		return 3;
	}

	public static function getGroups(): array {
        return ['samples_data'];
    }

	public function load(ObjectManager $manager) {
		$category = new Category();
		$category->setName("Grabs");
		$this->addReference(self::CATEGORY_GRABS_REFERENCE, $category);
		$manager->persist($category);

		$category = new Category();
		$category->setName("Flips");
		$this->addReference(self::CATEGORY_FLIPS_REFERENCE, $category);
		$manager->persist($category);

		$category = new Category();
		$category->setName("Rotations");
		$this->addReference(self::CATEGORY_ROTATIONS_REFERENCE, $category);
		$manager->persist($category);

		$category = new Category();
		$category->setName("Slides");
		$this->addReference(self::CATEGORY_SLIDES_REFERENCE, $category);
		$manager->persist($category);

		$manager->flush();
	}
}
