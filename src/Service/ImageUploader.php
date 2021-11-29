<?php

namespace App\Service;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader {
	public function isValidImage(UploadedFile $imageFile, string $type): bool {
		$type = str_replace("*", "", $type);

		return str_starts_with($imageFile->getClientMimeType(), $type);
	}

	public function uploadFile(UploadedFile $imageFile, string $dir, bool $upload = true): string {
		$imageExtension = $imageFile->guessExtension();

		// extension cannot be guessed
		if (!$imageExtension) {
			$imageExtension = 'bin';
		}

		$imageTargetFileName = Uuid::v4(). '.'. $imageExtension;

		if ($upload) {
			$imageFile->move($dir, $imageTargetFileName);
		}

		return str_replace("./", "/", $dir). $imageTargetFileName;
	}
}
