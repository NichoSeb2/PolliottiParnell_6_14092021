<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Media;
use App\Entity\Trick;
use App\Exception\FileTypeException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrickManager {
	public const CREATE_MODE = "create";
	public const EDIT_MODE = "edit";

	private ?FormInterface $form = null;

	private $medias = [];
	private $deletedMedias = [];

	public function __construct(private MediaUploader $mediaUploader, private TranslatorInterface $translator, private VideoIdExtractor $videoIdExtractor) {}

	public function processData(FormInterface $form, string $mode, Trick $trick, User $user): void {
		$this->form = $form;

		$coverImageFile = $this->form->get("coverImage")->get("file")->getData();

		if ($mode == self::CREATE_MODE && !$this->mediaUploader->isValidImage($coverImageFile, Media::ACCEPT_MIME_TYPE)) {
			throw new FileTypeException($this->translator->trans("form.trick.cover-image.wrong-mime-type", [], "validators"));
		}

		switch ($mode) {
			case self::CREATE_MODE:
				$trick->getCoverImage()
                    ->setUrl($this->mediaUploader->uploadFile($coverImageFile, Media::UPLOAD_DIR))
                    ->setAlt($this->form->get("coverImage")->get("alt")->getData())
                ;

				$trick
                    ->setAuthor($user)
                    ->updateSlug()
                ;
				break;
			case self::EDIT_MODE:
				if (!is_null($coverImageFile)) {
					if ($this->mediaUploader->isValidImage($coverImageFile, Media::ACCEPT_MIME_TYPE)) {
						$trick->getCoverImage()
							->setUrl($this->mediaUploader->uploadFile($coverImageFile, Media::UPLOAD_DIR))
						;
					} else {
						$this->form->get("coverImage")->addError(new FormError($this->translator->trans("form.trick.cover-image.wrong-mime-type", [], "validators")));
					}
				}

				$trick->addContributor($user);
				break;
			default:
				break;
		}

		foreach ($this->form->get("medias") as $index => $mediaData) {
			/** @var Media $media */
			$media = $mediaData->getData();
			$media->setTrick($trick);

			switch ($mode) {
				case self::CREATE_MODE:
					switch ($mediaData->get("type")->getData()) {
						case Media::MEDIA_TYPE_LOCAL_FILE:
							$mediaFile = $mediaData->get("file")->getData();
							$media
								->setUrl($this->mediaUploader->uploadFile($mediaFile, Media::UPLOAD_DIR))
								->setAlt($mediaData->get("alt")->getData())
							;
							break;
						case Media::MEDIA_TYPE_URL:
							$media->setUrl($mediaData->get("url")->getData());
							break;
						default:
							break;
					}
					break;
				case self::EDIT_MODE:
					if (is_null($media->getId())) {
						switch ($mediaData->get("type")->getData()) {
							case Media::MEDIA_TYPE_LOCAL_FILE:
								$mediaFile = $mediaData->get("file")->getData();
								$media
									->setUrl($this->mediaUploader->uploadFile($mediaFile, Media::UPLOAD_DIR))
									->setAlt($mediaData->get("alt")->getData())
								;
								break;
							case Media::MEDIA_TYPE_URL:
								$media->setUrl($mediaData->get("url")->getData());
								break;
							default:
								break;
						}
					} else {
						if ($this->mediaUploader->isValidVideoUrl($media->getUrl())) {
							$media->setUrl($mediaData->get("url")->getData());
						} else {
							$mediaFile = $mediaData->get("file")->getData();

							if (!is_null($mediaFile)) {
								$media
									->setUrl($this->mediaUploader->uploadFile($mediaFile, Media::UPLOAD_DIR))
								;
							}
						}
					}
					break;
				default:
					break;
			}

			$this->medias[] = $media;
		}

		$this->trick = $trick;
	}

	public function verifyVideoUrl(Media $media): void {
		$url = $media->getUrl();

		if ($this->mediaUploader->isValidVideoUrl($url)) {
			switch ($media->getType()) {
				case Media::MEDIA_VIDEO_TYPE_YOUTUBE:
					if (is_null($this->videoIdExtractor->getYoutubeId($url))) {
						throw new FileTypeException($this->translator->trans("form.trick.medias.url.wrong-url-format", [], "validators"));
					}
					break;
				case Media::MEDIA_VIDEO_TYPE_VIMEO:
					if (is_null($this->videoIdExtractor->getVimeoId($url))) {
						throw new FileTypeException($this->translator->trans("form.trick.medias.url.wrong-url-format", [], "validators"));
					}
					break;
				default:
					throw new FileTypeException($this->translator->trans("form.trick.medias.url.wrong-url-format", [], "validators"));
					break;
			}
		}
	}

	public function getForm(): ?FormInterface {
		return $this->form;
	}

	public function getTrick(): Trick {
		return $this->trick;
	}

	public function getMedias() : array {
		return $this->medias;
	}

	public function getDeletedMedias() : array {
		return $this->deletedMedias;
	}
}
