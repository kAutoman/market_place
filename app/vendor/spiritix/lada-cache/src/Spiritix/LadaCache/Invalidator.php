<?php
/**
 * This file is part of the spiritix/lada-cache package.
 *
 * @copyright Copyright (c) Matthias Isler <mi@matthias-isler.ch>
 * @license   MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiritix\LadaCache;

/**
 * Invalidates data in the cache.
 *
 * @package Spiritix\LadaCache
 * @author  Matthias Isler <mi@matthias-isler.ch>
 */
class Invalidator
{
    /**
     * Redis instance.
     *
     * @var Redis
     */
    protected $redis;

    /**
     * Initialize invalidator.
     *
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Invalidates all items in the cache having at least one of the given tags.
     *
     * Requests the affected items (hashes) from the storage for all tags provided.
     * Afterwards simply deletes all items and all tag sets.
     *
     * @param array $tags
     *
     * @return array The hashes that were invalidated
     */
    public function invalidate(array $tags)
    {
        $hashes = $this->getHashes($tags);

        // Prefix tags in order to delete them
        foreach ($tags as $key => $tag) {
            $tags[$key] = $this->redis->prefix($tag);
        }

        $this->deleteItems($hashes);
        $this->deleteItems($tags);

        return $hashes;
    }

    /**
     * Returns a list of all affected hashes for a given set of tags.
     *
     * @param array $tags
     *
     * @return array
     */
    private function getHashes(array $tags)
    {
        $hashes = [];

        foreach ($tags as $tag) {
            $tag = $this->redis->prefix($tag);

            if (!$this->redis->exists($tag)) {
                continue;
            }

            $hashes = array_merge($hashes, $this->redis->smembers($tag));
        }

        return array_unique($hashes);
    }

    /**
     * Deletes a given set of items in the cache.
     *
     * @param array $items
     */
    private function deleteItems(array $items)
    {
        foreach ($items as $item) {
            $this->redis->del($item);
        }
    }
}
