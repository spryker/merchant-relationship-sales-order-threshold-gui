<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface MerchantRelationshipSalesOrderThresholdGuiToStoreFacadeInterface
{
    /**
     * @param bool $fallbackToDefault
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(bool $fallbackToDefault = false): StoreTransfer;

    /**
     * @return array<\Generated\Shared\Transfer\StoreTransfer>
     */
    public function getAllStores(): array;

    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStoreByName($storeName): StoreTransfer;

    /**
     * @return bool
     */
    public function isDynamicStoreEnabled(): bool;
}
