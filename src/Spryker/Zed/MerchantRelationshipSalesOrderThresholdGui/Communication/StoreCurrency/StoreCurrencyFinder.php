<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\StoreCurrency;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToStoreFacadeInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\MerchantRelationshipSalesOrderThresholdGuiConfig;

class StoreCurrencyFinder implements StoreCurrencyFinderInterface
{
    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToStoreFacadeInterface
     */
    protected $storeFacade;

    public function __construct(
        MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface $currencyFacade,
        MerchantRelationshipSalesOrderThresholdGuiToStoreFacadeInterface $storeFacade
    ) {
        $this->currencyFacade = $currencyFacade;
        $this->storeFacade = $storeFacade;
    }

    public function getCurrencyTransferFromRequestParam(StoreTransfer $storeTransfer, ?string $storeCurrencyRequestParam): CurrencyTransfer
    {
        if (!$storeCurrencyRequestParam) {
            return $this->currencyFacade->fromIsoCode($storeTransfer->getDefaultCurrencyIsoCodeOrFail());
        }

        [$_, $currencyCode] = explode(
            MerchantRelationshipSalesOrderThresholdGuiConfig::STORE_CURRENCY_DELIMITER,
            $storeCurrencyRequestParam,
        );

        return $this->currencyFacade->fromIsoCode($currencyCode);
    }

    public function getStoreTransferFromRequestParam(?string $storeCurrencyRequestParam): StoreTransfer
    {
        if (!$storeCurrencyRequestParam) {
            return $this->storeFacade->getCurrentStore(true);
        }

        [$storeName] = explode(
            MerchantRelationshipSalesOrderThresholdGuiConfig::STORE_CURRENCY_DELIMITER,
            $storeCurrencyRequestParam,
        );

        return $this->storeFacade->getStoreByName($storeName);
    }
}
