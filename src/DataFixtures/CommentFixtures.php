<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CommentFixtures extends Fixture implements OrderedFixtureInterface {
	public function __construct() {}

	public function getOrder() {
		return 5;
	}

	public function load(ObjectManager $manager) {
		$comment = new Comment();
		$comment
			->setAuthor($this->getReference(UserFixtures::COMMENTATOR_REFERENCE))
			->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
			->setContent("Ipsum duis non nulla aliquip excepteur ea excepteur quis Lorem laboris eu.")
		;
		$manager->persist($comment);

		$manager->flush();
	}
}
