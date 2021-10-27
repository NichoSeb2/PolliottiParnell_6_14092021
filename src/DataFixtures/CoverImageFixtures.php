<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CoverImageFixtures extends Fixture implements OrderedFixtureInterface {
	public const MEDIA_TAIL_GRAB_REFERENCE = "media-tail-grab";
	public const MEDIA_NOSE_GRAB_REFERENCE = "media-nose-grab";
	public const MEDIA_TRUCK_DRIVER_REFERENCE = "media-truck-driver";
	public const MEDIA_INDY_REFERENCE = "media-indy";

	public function __construct() {}

	public function getOrder() {
		return 3;
	}

	public function load(ObjectManager $manager) {
		$media = new Media();
		$media
			->setUrl("/uploads/fixtures/tail_grab.jpg")
			->setAlt("Tail grab")
		;
		$this->addReference(self::MEDIA_TAIL_GRAB_REFERENCE, $media);
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("/uploads/fixtures/tail_grab.jpg")
			->setAlt("Tail grab")
		;
		$this->addReference(self::MEDIA_NOSE_GRAB_REFERENCE, $media);
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("/uploads/fixtures/tail_grab.jpg")
			->setAlt("Tail grab")
		;
		$this->addReference(self::MEDIA_TRUCK_DRIVER_REFERENCE, $media);
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("/uploads/fixtures/tail_grab.jpg")
			->setAlt("Tail grab")
		;
		$this->addReference(self::MEDIA_INDY_REFERENCE, $media);
		$manager->persist($media);

		$manager->flush();
	}
}
