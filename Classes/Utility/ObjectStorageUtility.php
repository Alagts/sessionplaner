<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Utility;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class ObjectStorageUtility
{
    /**
     * @const string
     */
    public const SORT_ASCENDING = 'ASC';

    /**
     * @const string
     */
    public const SORT_DESCENDING = 'DESC';

    public static function sort(
        ObjectStorage $objectStorage,
        string $property,
        string $order = self::SORT_ASCENDING
    ): ObjectStorage {
        $inventory = [];
        foreach ($objectStorage as $item) {
            $key = $item->_getProperty($property) . '-' . $item->_getProperty('uid');
            $inventory[$key] = $item;
        }

        if ($order === self::SORT_ASCENDING) {
            ksort($inventory);
        } else {
            krsort($inventory);
        }

        /** @var ObjectStorage $storage */
        $storage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
        foreach ($inventory as $item) {
            $storage->attach($item);
        }

        return $storage;
    }
}
