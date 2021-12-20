<?php

namespace App\EventListener;

use App\Entity\Media;
use App\Service\MediaUploader;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MediaListener {
	public function __construct(private MediaUploader $mediaUploader){}

	public function preRemove(Media $media, LifecycleEventArgs $event): void {
		/** @var Media $media */
		$media = $event->getObjectManager()->getRepository(Media::class)->findOneBy(['id' => $media->getId()]);

		if (!$this->mediaUploader->isValidVideoUrl($media->getUrl())) {
			$this->mediaUploader->removeFile(".". $media->getUrl());
		}
	}
}
