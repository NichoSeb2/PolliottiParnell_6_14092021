<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Symfony\Component\Uid\Uuid;
use App\DataFixtures\TrickFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class MediaFixtures extends Fixture implements OrderedFixtureInterface {
	public function __construct() {}

	public function getOrder() {
		return 6;
	}

	public function load(ObjectManager $manager) {
		$media = new Media();
		$media
			->setUrl(self::newLocalFile("/uploads/fixtures/tail_grab.jpg"))
			->setAlt("Tail grab")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
		;
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/embed/axNnKy-jfWw")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
		;
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("https://www.youtube.com/watch?v=t705_V-RDcQ")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
		;
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("https://vimeo.com/groups/snowboarding/videos/630938580")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
		;
		$manager->persist($media);

		$media = new Media();
		$media
			->setUrl("https://player.vimeo.com/video/59574563?h=8215b0763d")
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
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
