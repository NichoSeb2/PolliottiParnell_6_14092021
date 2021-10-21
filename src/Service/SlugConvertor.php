<?php

namespace App\Service;

use Cocur\Slugify\Slugify;

class SlugConvertor {
    private Slugify $slugify;

	public function __construct() {
        $this->slugify = new Slugify();
	}

	public function slugify(string $before): string {
		return $this->slugify->slugify($before);
	}
}
