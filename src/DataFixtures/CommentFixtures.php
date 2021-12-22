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
		for ($i = 0; $i < 100; $i++) { 
			$comment = new Comment();
			$comment
				->setAuthor($this->getReference(UserFixtures::VERIFIED_USER_REFERENCE))
				->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_REFERENCE))
				->setContent("Duis magna duis exercitation tempor non consequat. ". $i)
			;
			if ($i % 2 == 0) {
				$comment->setStatus(true);
			}
			$manager->persist($comment);
			$manager->flush();
		}
	}
}
