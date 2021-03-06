<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public const VERIFIED_USER_REFERENCE = "verified_user";
	public const NOT_VERIFIED_USER_REFERENCE = "not_verified_user";

	public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

	public function getOrder() {
		return 2;
	}

	public static function getGroups(): array {
        return ['samples_data'];
    }

	public function load(ObjectManager $manager) {
		$user = new User();
		$user
			->setUsername("John Doe")
			->setEmail("john.doe@example.com")
			->setIsVerified(true)
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'Password'
			))
		;
		$this->addReference(self::VERIFIED_USER_REFERENCE, $user);
		$manager->persist($user);

		$user = new User();
		$user
			->setUsername("Jane Doe")
			->setEmail("jane.doe@gmail.com")
			->setVerificationToken(Uuid::v4())
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'Password'
			))
		;
		$this->addReference(self::NOT_VERIFIED_USER_REFERENCE, $user);
		$manager->persist($user);

		$manager->flush();
	}
}
