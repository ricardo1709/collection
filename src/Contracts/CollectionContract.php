<?php
declare(strict_types=1);

namespace Ricrado1709\Collection;

use ArrayAccess;
use Closure;
use IteratorAggregate;

interface CollectionContract extends IteratorAggregate, ArrayAccess
{
	/**
	 * Determise whether the offset contains any items.
	 *
	 * @param  integer|string $offset
	 * @return boolean
	 */
	public function has($offset): bool;

	/**
	 * Get the item on the offset.
	 *
	 * @param  integer|string $offset
	 * @param  mixed $default
	 * @return void
	 */
	public function get($offset, $default);

	/**
	 * Set the item on the offset
	 *
	 * @param  integer|string $offset
	 * @param  mixed $value
	 * @return void
	 */
	public function set($offset, $value);

	/**
	 * removes the item.
	 *
	 * @param  integer|string $offset
	 * @return mixed
	 */
	public function remove($offset);

	/**
	 * Get the keys and return the new collection.
	 *
	 * @return CollectionContract<integer, integer|string>
	 */
	public function getKeys(): CollectionContract;

	/**
	 * transfrom the collection and return the new collection.
	 *
	 * @param integer $length
	 * @param boolean $preserveKeys
	 * @return CollectionContract<integer, CollectionContract<integer|string, mixed>>
	 */
	public function chunk(int $length, bool $preserveKeys = true): CollectionContract;

	/**
	 * transfrom the collection
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function transform(Closure $closure): CollectionContract;

	/**
	 * transfrom the collection and return the new collection.
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function map(Closure $closure): CollectionContract;

	/**
	 * Filters the collection
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function filter(Closure $closure): CollectionContract;

	/**
	 * Reduces the collection
	 *
	 * @param Closure $closure
	 * @return mixed
	 */
	public function reduce(Closure $closure);
}