<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CoverImageFixtures extends Fixture implements OrderedFixtureInterface {
	public const MEDIA_TAIL_GRAB_REFERENCE = "media-tail-grab";

	public const MEDIA_NOSE_GRAB_REFERENCE = "media-nose-grab";

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

		$manager->flush();
	}
}
