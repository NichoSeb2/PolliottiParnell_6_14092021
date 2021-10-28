<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CoverImageFixtures;
use App\Service\SlugConvertor;
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
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Tail grab")
			->updateSlug()
			->setDescription("Saisie de la partie arrière de la planche, avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_TAIL_GRAB_REFERENCE))
			->addContributor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->addContributor($this->getReference(UserFixtures::COMMENTATOR_REFERENCE))
		;
		$this->addReference(self::TRICK_TAIL_GRAB_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Nose grab")
			->updateSlug()
			->setDescription("Saisie de la partie avant de la planche, avec la main avant.")
			->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_NOSE_GRAB_REFERENCE))
		;
		$manager->persist($trick);
		$manager->flush();

		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Truck driver")
			->updateSlug()
			->setDescription("Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).")
			->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_TRUCK_DRIVER_REFERENCE))
		;
		$manager->persist($trick);
		$manager->flush();

		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Indy")
			->updateSlug()
			->setDescription("Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::ADMIN_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_INDY_REFERENCE))
		;
		$manager->persist($trick);
		$manager->flush();
	}
}
