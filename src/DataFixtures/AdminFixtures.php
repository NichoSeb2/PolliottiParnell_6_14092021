<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements OrderedFixtureInterface, FixtureGroupInterface {
	public const ADMIN_REFERENCE = "admin";

	public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

	public function getOrder() {
		return 1;
	}

	public static function getGroups(): array {
        return ['users', 'samples_data'];
    }

	public function load(ObjectManager $manager) {
		$user = new User();
		$user
			->setUsername("Administrator")
			->setEmail("administrator@snowtricks.com")
			->setRoles(['ROLE_ADMIN'])
			->setIsVerified(true)
			->setPassword($this->passwordHasher->hashPassword(
				$user,
				'Password'
			))
		;
		$this->addReference(self::ADMIN_REFERENCE, $user);
		$manager->persist($user);

		$manager->flush();
	}
}
