<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\DataFixtures\MediaFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CoverImageFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public const MEDIA_180_REFERENCE = "media-180";
	public const MEDIA_JAPAN_AIR_REFERENCE = "media-japan-air";
	public const MEDIA_TRUCK_DRIVER_REFERENCE = "media-truck-driver";
	public const MEDIA_MUTE_REFERENCE = "media-mute";
	public const MEDIA_STALEFISH_REFERENCE = "media-stalefish";
	public const MEDIA_NOSE_GRAB_REFERENCE = "media-nose-grab";
	public const MEDIA_SEAT_BELT_REFERENCE = "media-seat-belt";
	public const MEDIA_TAIL_GRAB_REFERENCE = "media-tail-grab";
	public const MEDIA_INDY_REFERENCE = "media-indy";
	public const MEDIA_720_REFERENCE = "media-720";

	public function __construct() {}

	public function getOrder() {
		return 4;
	}

	public static function getGroups(): array {
        return ['samples_data', 'dev'];
    }

	public function load(ObjectManager $manager) {
		// Le 180
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/180.jpg"))
			->setAlt("Le 180")
		;
		$this->addReference(self::MEDIA_180_REFERENCE, $media);
		$manager->persist($media);

		// Japan Air
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/japan_air.jpg"))
			->setAlt("Japan Air")
		;
		$this->addReference(self::MEDIA_JAPAN_AIR_REFERENCE, $media);
		$manager->persist($media);

		$manager->flush();

		// Truck Driver
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/truck_driver.jpg"))
			->setAlt("Truck Driver")
		;
		$this->addReference(self::MEDIA_TRUCK_DRIVER_REFERENCE, $media);
		$manager->persist($media);

		// Mute
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/mute.jpg"))
			->setAlt("Mute")
		;
		$this->addReference(self::MEDIA_MUTE_REFERENCE, $media);
		$manager->persist($media);

		// StaleFish
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/stalefish.jpg"))
			->setAlt("StaleFish")
		;
		$this->addReference(self::MEDIA_STALEFISH_REFERENCE, $media);
		$manager->persist($media);

		// Nose grab
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/nose_grab.jpg"))
			->setAlt("Nose grab")
		;
		$this->addReference(self::MEDIA_NOSE_GRAB_REFERENCE, $media);
		$manager->persist($media);

		// Seat Belt
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/seat_belt.jpg"))
			->setAlt("Seat Belt")
		;
		$this->addReference(self::MEDIA_SEAT_BELT_REFERENCE, $media);
		$manager->persist($media);

		// Tail Grab
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/tail_grab.jpg"))
			->setAlt("Tail Grab")
		;
		$this->addReference(self::MEDIA_TAIL_GRAB_REFERENCE, $media);
		$manager->persist($media);

		// Indy
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/indy.jpg"))
			->setAlt("Indy")
		;
		$this->addReference(self::MEDIA_INDY_REFERENCE, $media);
		$manager->persist($media);

		// 720
		$media = new Media();
		$media
			->setUrl(MediaFixtures::newLocalFile("/uploads/fixtures/180.jpg"))
			->setAlt("720")
		;
		$this->addReference(self::MEDIA_720_REFERENCE, $media);
		$manager->persist($media);

		$manager->flush();
	}
}
