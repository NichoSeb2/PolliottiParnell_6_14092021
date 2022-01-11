<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Symfony\Component\Uid\Uuid;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class MediaFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public function __construct() {}

	public function getOrder() {
		return 6;
	}

	public static function getGroups(): array {
        return ['samples_data'];
    }

	public function load(ObjectManager $manager) {
		// Le 180
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=XyARvRQhGgk")
			->setTrick($this->getReference(TrickFixtures::TRICK_180_REFERENCE))
		;
		$manager->persist($media);

		// Japan Air
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=CzDjM7h_Fwo")
			->setTrick($this->getReference(TrickFixtures::TRICK_JAPAN_AIR_REFERENCE))
		;
		$manager->persist($media);

		// Truck Driver
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=6tgjY8baFT0")
			->setTrick($this->getReference(TrickFixtures::TRICK_TRUCK_DRIVER_REFERENCE))
		;
		$manager->persist($media);

		// Mute
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=jm19nEvmZgM")
			->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_REFERENCE))
		;
		$manager->persist($media);

		// Stalefish
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=f9FjhCt_w2U")
			->setTrick($this->getReference(TrickFixtures::TRICK_STALEFISH_REFERENCE))
		;
		$manager->persist($media);

		// Nose Grab
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=mfm3a3og3LI")
			->setTrick($this->getReference(TrickFixtures::TRICK_NOSE_GRAB_REFERENCE))
		;
		$manager->persist($media);

		// Seat Belt
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=4vGEOYNGi_c")
			->setTrick($this->getReference(TrickFixtures::TRICK_SEAT_BELT_REFERENCE))
		;
		$manager->persist($media);

		// Tail Grab
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=YAElDqyD-3I")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
		;
		$manager->persist($media);

		// Indy
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=6yA3XqjTh_w")
			->setTrick($this->getReference(TrickFixtures::TRICK_INDY_REFERENCE))
		;
		$manager->persist($media);

		// Indy
		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=H2MKP1epC7k")
			->setTrick($this->getReference(TrickFixtures::TRICK_720_REFERENCE))
		;
		$manager->persist($media);

		$manager->flush();
	}

	public static function newLocalFile(string $path): string {
		$rootDir = str_replace("/src/DataFixtures", "", dirname(__FILE__));
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$resultPath = str_replace(".", "", Media::UPLOAD_DIR). Uuid::v4(). ".". $ext;

		copy($rootDir. "/public". $path, $rootDir. "/public". $resultPath);

		return $resultPath;
	}
}
