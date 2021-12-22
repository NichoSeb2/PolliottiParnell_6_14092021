<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface {
	public const ADMIN_REFERENCE = "admin";
	public const VERIFIED_USER_REFERENCE = "verified_user";

	public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

	public function getOrder() {
		return 1;
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
		$this->addReference(self::ADMIN_REFERENCE, $user);
		$manager->persist($user);

		$user = new User();
		$user
			->setUsername("John")
			->setEmail("john.doe@gmail.com")
			->setIsVerified(true)
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'azerty'
			))
		;
		$this->addReference(self::VERIFIED_USER_REFERENCE, $user);
		$manager->persist($user);

		$user = new User();
		$user
			->setUsername("Jane")
			->setEmail("jane.doe@gmail.com")
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
