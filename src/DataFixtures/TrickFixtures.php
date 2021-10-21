<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CoverImageFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class TrickFixtures extends Fixture implements OrderedFixtureInterface {
	public const TRICK_TAIL_GRAB_REFERENCE = "trick-tail-grab";

	public function __construct() {}

	public function getDependencies() {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            MediaFixtures::class,
        ];
    }

	public function getOrder() {
		return 4;
	}

	public function load(ObjectManager $manager) {
		$trick = new Trick();
		$trick
			->setName("Tail grab")
			->updateSlug()
			->setDescription("Saisie de la partie arrière de la planche, avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_TAIL_GRAB_REFERENCE))
		;
		$this->addReference(self::TRICK_TAIL_GRAB_REFERENCE, $trick);
		$manager->persist($trick);

		$manager->flush();
	}
}
