<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture{
	private $passwordHasher;

	public function __construct(UserPasswordHasherInterface $passwordHasher) {
		$this->passwordHasher = $passwordHasher;
	}

	public function load(ObjectManager $manager) {
		$user = new User();
		$user
			->setUsername("NichoSeb2")
			->setEmail("parnell.polliotti@play-for-eternity.net")
			->setRoles(['ROLE_ADMIN'])
			->setIsVerified(true)
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'azerty'
			))
		;
		$manager->persist($user);

		$user = new User();
		$user
			->setUsername("John")
			->setEmail("john.doe@gmail.com")
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'azerty'
			))
			->setVerificationToken(Uuid::v4())
		;
		$manager->persist($user);

		$manager->flush();
	}
}
