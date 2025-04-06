<?php

namespace WPML\StringTranslation\Infrastructure\StringGettext\Repository;

use WPML\StringTranslation\Application\Setting\Repository\FilesystemRepositoryInterface;
use WPML\StringTranslation\Application\StringGettext\Repository\FrontendQueueRepositoryInterface;

class FrontendQueueJsonRepository implements FrontendQueueRepositoryInterface {

	/** @var FilesystemRepositoryInterface */
	private $filesystemRepository;

	public function __construct(
		FilesystemRepositoryInterface $filesystemRepository
	) {
		$this->filesystemRepository = $filesystemRepository;
	}

	private function getQueueFilepath(): string {
		$this->filesystemRepository->createQueueDir();
		return $this->filesystemRepository->getQueueDir() . 'gettextfrontend.json';
	}

	public function save( array $data ) {
		file_put_contents( $this->getQueueFilepath(), json_encode( $data ) );
	}

	public function get(): array {
		$filepath = $this->getQueueFilepath();

		$data = [];
		if ( file_exists( $filepath ) && is_readable( $filepath ) ) {
			$data = json_decode( file_get_contents( $filepath ), true );
		}

		return $data;
	}

	public function remove() {
		$queueFilepath = $this->getQueueFilepath();
		if ( file_exists( $queueFilepath ) ) {
			unlink( $queueFilepath );
		}
	}
}