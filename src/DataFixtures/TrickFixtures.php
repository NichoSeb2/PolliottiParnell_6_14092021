<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Service\SlugConvertor;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CoverImageFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class TrickFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public const TRICK_180_REFERENCE = "trick-180";
	public const TRICK_JAPAN_AIR_REFERENCE = "trick-japan-air";
	public const TRICK_TRUCK_DRIVER_REFERENCE = "trick-truck-driver";
	public const TRICK_MUTE_REFERENCE = "trick-mute";
	public const TRICK_STALEFISH_REFERENCE = "trick-stalefish";
	public const TRICK_NOSE_GRAB_REFERENCE = "trick-nose-grab";
	public const TRICK_SEAT_BELT_REFERENCE = "trick-seat-belt";
	public const TRICK_TAIL_GRAB_REFERENCE = "trick-tail-grab";
	public const TRICK_INDY_REFERENCE = "trick-indy";
	public const TRICK_720_REFERENCE = "trick-720";

	public function __construct() {}

	public function getDependencies() {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
            MediaFixtures::class,
        ];
    }

	public function getOrder() {
		return 5;
	}

	public static function getGroups(): array {
        return ['samples_data'];
    }

	public function load(ObjectManager $manager) {
		// Le 180
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Le 180")
			->updateSlug()
			->setDescription("Un 180 désigne un demi-tour, soit 180 degrés d'angle.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATIONS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_180_REFERENCE))
		;
		$this->addReference(self::TRICK_180_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Japan Air
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Japan Air")
			->updateSlug()
			->setDescription("Saisie de l'avant de la planche, avec la main avant, du côté de la carre frontside.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_JAPAN_AIR_REFERENCE))
		;
		$this->addReference(self::TRICK_JAPAN_AIR_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Truck Driver
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Truck Driver")
			->updateSlug()
			->setDescription("Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_TRUCK_DRIVER_REFERENCE))
		;
		$this->addReference(self::TRICK_TRUCK_DRIVER_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Mute
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Mute")
			->updateSlug()
			->setDescription("Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_MUTE_REFERENCE))
		;
		$this->addReference(self::TRICK_MUTE_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Stalefish
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Stalefish")
			->updateSlug()
			->setDescription("Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_STALEFISH_REFERENCE))
		;
		$this->addReference(self::TRICK_STALEFISH_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Nose Grab
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Nose Grab")
			->updateSlug()
			->setDescription("Saisie de la partie avant de la planche, avec la main avant.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_NOSE_GRAB_REFERENCE))
		;
		$this->addReference(self::TRICK_NOSE_GRAB_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Seat Belt
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Seat Belt")
			->updateSlug()
			->setDescription("Saisie du carre frontside à l'arrière avec la main avant.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_SEAT_BELT_REFERENCE))
		;
		$this->addReference(self::TRICK_SEAT_BELT_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Tail Grab
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Tail Grab")
			->updateSlug()
			->setDescription("Saisie de la partie arrière de la planche, avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_TAIL_GRAB_REFERENCE))
		;
		$this->addReference(self::TRICK_TAIL_GRAB_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Indy
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Indy")
			->updateSlug()
			->setDescription("Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_GRABS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_INDY_REFERENCE))
		;
		$this->addReference(self::TRICK_INDY_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();

		// Le 720
		$trick = new Trick(new SlugConvertor(), $manager);
		$trick
			->setName("Le 720")
			->updateSlug()
			->setDescription("Un 720 ou sept deux pour deux tours complets.")
			->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
			->setCategory($this->getReference(CategoryFixtures::CATEGORY_ROTATIONS_REFERENCE))
			->setCoverImage($this->getReference(CoverImageFixtures::MEDIA_720_REFERENCE))
		;
		$this->addReference(self::TRICK_720_REFERENCE, $trick);
		$manager->persist($trick);
		$manager->flush();
	}
}
