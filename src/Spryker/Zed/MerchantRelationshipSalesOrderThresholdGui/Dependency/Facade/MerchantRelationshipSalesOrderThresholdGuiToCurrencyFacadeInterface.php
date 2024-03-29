<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;

interface MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface
{
    /**
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     *
     * @return array<\Generated\Shared\Transfer\StoreWithCurrencyTransfer>
     */
    public function getAllStoresWithCurrencies(): array;

    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer;

    /**
     * @param string $isoCode
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function fromIsoCode($isoCode): CurrencyTransfer;
}
