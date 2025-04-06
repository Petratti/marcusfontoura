<?php

namespace WPML\StringTranslation\Infrastructure\StringGettext\Command;

use WPML\StringTranslation\Application\StringGettext\Command\CreateFileCommandInterface;

class CreatePhpFileCommand implements CreateFileCommandInterface {
	public function run( array $queue, string $filepath ) {
		$contents = $this->export( $queue );
		file_put_contents( $filepath, $contents );
		if ( function_exists( 'opcache_invalidate' ) ) {
			opcache_invalidate( $filepath, true );
		}
	}

	private function export( array $items ): string {
		$data = [ 'items' => $items ];

		return '<?php' . PHP_EOL . 'return ' . $this->var_export( $data ) . ';' . PHP_EOL;
	}

	private function var_export( $value ): string {
		if ( ! is_array( $value ) ) {
			return var_export( $value, true );
		}

		$entries = [];

		$isList = $this->arrayIsList( $value );

		foreach ( $value as $key => $val ) {
			$entries[] = $isList ? $this->var_export( $val ) : var_export( $key, true ) . '=>' . $this->var_export( $val );
		}

		return '[' . implode( ',', $entries ) . ']';
	}

	private function arrayIsList( array $arr ): bool {
		if ( ( array() === $arr ) || ( array_values( $arr ) === $arr ) ) {
			return true;
		}

		$next_key = -1;

		foreach ( $arr as $k => $v ) {
			if ( ++$next_key !== $k ) {
				return false;
			}
		}

		return true;
	}
}