<?php
declare(strict_types=1);

namespace Ricrado1709\Collection;

use ArrayAccess;
use ArrayIterator;
use Closure;
use IteratorAggregate;
use Traversable;
use TypeError;

class Collection implements IteratorAggregate, ArrayAccess
{
	protected $map;

	public function __construct(array $map)
	{
		$this->map = $map;
	}

	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->map);
	}

	public function offsetExists($offset): bool
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		return array_key_exists($offset, $this->map);
	}

	public function offsetGet($offset)
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		return $this->map[$offset];
	}

	public function offsetSet($offset, $value): void
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		$this->map[$offset] = $value;
	}

	public function offsetUnset($offset): void
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		unset($this->map[$offset]);
	}

	/**
	 * Determise whether the offset contains any items.
	 *
	 * @param  integer|string $offset
	 * @return boolean
	 */
	public function has($offset): bool
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		return $this->offsetExists($offset);
	}

	/**
	 * Get the item on the offset.
	 *
	 * @param  integer|string $offset
	 * @param  mixed $default
	 * @return void
	 */
	public function get($offset, $default)
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		return $this->has($offset) ? $this->offsetGet($offset) : $default;
	}

	/**
	 * Set the item on the offset
	 *
	 * @param  integer|string $offset
	 * @param  mixed $value
	 * @return void
	 */
	public function set($offset, $value)
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		$this->offsetSet($offset, $value);
	}

	/**
	 * removes the item.
	 *
	 * @param  integer|string $offset
	 * @return mixed
	 */
	public function remove($offset)
	{
		if (array_search(gettype($offset), ['string', 'integer']) === false) {
			throw new TypeError("Offset must be an integer or string");
		}

		if (!$this->has($offset)) {
			return null;
		}

		$ret = $this->get($offset, null);

		$this->offsetUnset($offset);

		return $ret;
	}

	/**
	 * Get the keys and return the new collection.
	 *
	 * @return CollectionContract<integer, integer|string>
	 */
	public function getKeys(): Collection
	{
		return new Collection(array_keys($this->map));
	}

	/**
	 * transfrom the collection and return the new collection.
	 *
	 * @param integer $length
	 * @param boolean $preserveKeys
	 * @return CollectionContract<integer, CollectionContract<integer|string, mixed>>
	 */
	public function chunk(int $length, bool $preserveKeys = true)
	{
		return (new Collection(array_chunk($this->map, $length, $preserveKeys)))
			->transform(function ($item) {
				return new Collection($item);
			});
	}

	/**
	 * transfrom the collection
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function transform(Closure $closure): Collection
	{
		$this->map = array_map($closure, $this->map);

		return $this;
	}

	/**
	 * transfrom the collection and return the new collection.
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function map(Closure $closure): Collection
	{
		return new Collection(array_map($closure, $this->map));
	}

	/**
	 * Filters the collection
	 *
	 * @param Closure $closure
	 * @return CollectionContract<integer|string, mixed>
	 */
	public function filter(Closure $closure): Collection
	{
		$this->map = array_filter($this->map, $closure, ARRAY_FILTER_USE_BOTH);

		return $this;
	}

	/**
	 * Reduces the collection
	 *
	 * @param Closure $closure
	 * @return mixed
	 */
	public function reduce(Closure $closure)
	{
		return array_reduce($this->map, $closure);
	}
}