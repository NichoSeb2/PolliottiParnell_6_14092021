<?php

namespace App\Purger;

use App\Entity\User;
use ReflectionClass;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurgerInterface;

class CustomPurger implements ORMPurgerInterface {
	private EntityManagerInterface $em;

	private function getPurgeList(): array {
		return [
			(new ReflectionClass(Comment::class))->getName(), 
			(new ReflectionClass(Trick::class))->getName(), 
			(new ReflectionClass(Media::class))->getName(), 
			(new ReflectionClass(Category::class))->getName(), 
			(new ReflectionClass(User::class))->getName(), 
		];
	}

	public function setEntityManager(EntityManagerInterface $em) {
		$this->em = $em;
	}

    public function purge(): void {
		// Delete media-trick relation
		$this->em
			->createQueryBuilder()
			->update((new ReflectionClass(Media::class))->getName(), 'm')
			->set('m.trick', ':trick')
			->setParameter('trick', null)
			->getQuery()
			->execute()
		;

		// Delete all table content
		foreach ($this->getPurgeList() as $entity) {
			$this->em
				->createQuery("DELETE FROM ". $entity)
				->execute()
			;
		}
	}
}