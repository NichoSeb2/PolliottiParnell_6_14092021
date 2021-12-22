<?php

namespace App\Service;

use App\Entity\Media;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaUploader {
	public function isValidImage(UploadedFile $imageFile, string $type): bool {
		$type = str_replace("*", "", $type);

		return str_starts_with($imageFile->getClientMimeType(), $type);
	}

	public function isValidVideoUrl(string|null $url = ""): bool {
		if (is_null($url)) {
			$url = "";
		}

		return preg_match(VideoIdExtractor::VIDEO_URL_REGEX, $url);
	}

	public function uploadFile(UploadedFile $file, string $dir, bool $upload = true): string {
		$fileExtension = $file->guessExtension();

		// extension cannot be guessed
		if (!$fileExtension) {
			$fileExtension = 'bin';
		}

		$targetFileName = Uuid::v4(). '.'. $fileExtension;

		if ($upload) {
			$file->move($dir, $targetFileName);
		}

		return str_replace("./", "/", $dir). $targetFileName;
	}

	public function removeFile(string $path): bool {
		if (str_starts_with($path, Media::UPLOAD_DIR. "fixtures/")) {
			return false;
		}

		if (file_exists($path)) {
			return unlink($path);
		}

		return false;
	}
}
