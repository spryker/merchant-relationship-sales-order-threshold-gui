<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\DataProvider\ThresholdGroup\Resolver\MerchantRelationshipThresholdDataProviderResolverInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\MerchantRelationshipThresholdType;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\Type\ThresholdGroup\MerchantRelationshipHardMaximumThresholdType;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\Type\ThresholdGroup\MerchantRelationshipHardThresholdType;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\Type\ThresholdGroup\MerchantRelationshipSoftThresholdType;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToLocaleFacadeInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToMerchantRelationshipSalesOrderThresholdFacadeInterface;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\MerchantRelationshipSalesOrderThresholdGuiConfig;

class MerchantRelationshipThresholdDataProvider
{
    /**
     * @var string
     */
    protected const FORMAT_STORE_CURRENCY_ROW_LABEL = '%s - %s [%s]';

    /**
     * @var string
     */
    protected const FORMAT_STORE_CURRENCY_ROW_VALUE = '%s%s%s';

    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToMerchantRelationshipSalesOrderThresholdFacadeInterface
     */
    protected $merchantRelationshipSalesOrderThresholdFacade;

    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToLocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @var \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\DataProvider\ThresholdGroup\Resolver\MerchantRelationshipThresholdDataProviderResolverInterface
     */
    protected $globalThresholdDataProviderResolver;

    /**
     * @var array<\Spryker\Zed\MerchantRelationshipSalesOrderThresholdGuiExtension\Dependency\Plugin\SalesOrderThresholdFormExpanderPluginInterface>
     */
    protected $formExpanderPlugins;

    /**
     * @param \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToMerchantRelationshipSalesOrderThresholdFacadeInterface $merchantRelationshipSalesOrderThresholdFacade
     * @param \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface $currencyFacade
     * @param \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Dependency\Facade\MerchantRelationshipSalesOrderThresholdGuiToLocaleFacadeInterface $localeFacade
     * @param \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Communication\Form\DataProvider\ThresholdGroup\Resolver\MerchantRelationshipThresholdDataProviderResolverInterface $globalThresholdDataProviderResolver
     * @param array<\Spryker\Zed\MerchantRelationshipSalesOrderThresholdGuiExtension\Dependency\Plugin\SalesOrderThresholdFormExpanderPluginInterface> $formExpanderPlugins
     */
    public function __construct(
        MerchantRelationshipSalesOrderThresholdGuiToMerchantRelationshipSalesOrderThresholdFacadeInterface $merchantRelationshipSalesOrderThresholdFacade,
        MerchantRelationshipSalesOrderThresholdGuiToCurrencyFacadeInterface $currencyFacade,
        MerchantRelationshipSalesOrderThresholdGuiToLocaleFacadeInterface $localeFacade,
        MerchantRelationshipThresholdDataProviderResolverInterface $globalThresholdDataProviderResolver,
        array $formExpanderPlugins
    ) {
        $this->merchantRelationshipSalesOrderThresholdFacade = $merchantRelationshipSalesOrderThresholdFacade;
        $this->currencyFacade = $currencyFacade;
        $this->localeFacade = $localeFacade;
        $this->globalThresholdDataProviderResolver = $globalThresholdDataProviderResolver;
        $this->formExpanderPlugins = $formExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return array<string, mixed>
     */
    public function getOptions(CurrencyTransfer $currencyTransfer): array
    {
        return [
            'allow_extra_fields' => true,
            MerchantRelationshipThresholdType::OPTION_CURRENCY_CODE => $currencyTransfer->getCode(),
            MerchantRelationshipThresholdType::OPTION_STORE_CURRENCY_ARRAY => $this->getStoreCurrencyList(),
            MerchantRelationshipThresholdType::OPTION_HARD_TYPES_ARRAY => $this->getHardTypesList(),
            MerchantRelationshipThresholdType::OPTION_HARD_MAXIMUM_TYPES_ARRAY => $this->getHardMaximumTypesList(),
            MerchantRelationshipThresholdType::OPTION_SOFT_TYPES_ARRAY => $this->getSoftTypesList(),
            MerchantRelationshipThresholdType::OPTION_LOCALE => $this->localeFacade->getCurrentLocaleName(),
        ];
    }

    /**
     * @param int $idMerchantRelationship
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return array
     */
    public function getData(
        int $idMerchantRelationship,
        StoreTransfer $storeTransfer,
        CurrencyTransfer $currencyTransfer
    ): array {
        $data = [
            MerchantRelationshipThresholdType::FIELD_ID_MERCHANT_RELATIONSHIP => $idMerchantRelationship,
            MerchantRelationshipThresholdType::FIELD_HARD => [
                MerchantRelationshipHardThresholdType::FIELD_STRATEGY => current($this->getHardTypesList()),
            ],
            MerchantRelationshipThresholdType::FIELD_HARD_MAXIMUM => [
                MerchantRelationshipHardMaximumThresholdType::FIELD_STRATEGY => current($this->getHardMaximumTypesList()),
            ],
            MerchantRelationshipThresholdType::FIELD_SOFT => [
                MerchantRelationshipSoftThresholdType::FIELD_STRATEGY => current($this->getSoftTypesList()),
            ],
        ];

        $merchantRelationshipSalesOrderThresholdTransfers = $this->getSalesOrderThresholdTransfers($idMerchantRelationship, $storeTransfer, $currencyTransfer);
        foreach ($merchantRelationshipSalesOrderThresholdTransfers as $merchantRelationshipSalesOrderThresholdTransfer) {
            if (
                $this->globalThresholdDataProviderResolver
                ->hasMerchantRelationshipThresholdDataProviderByStrategyGroup($merchantRelationshipSalesOrderThresholdTransfer->getSalesOrderThresholdValue()->getSalesOrderThresholdType()->getThresholdGroup())
            ) {
                $data = $this->globalThresholdDataProviderResolver
                    ->resolveMerchantRelationshipThresholdDataProviderByStrategyGroup($merchantRelationshipSalesOrderThresholdTransfer->getSalesOrderThresholdValue()->getSalesOrderThresholdType()->getThresholdGroup())
                    ->mapSalesOrderThresholdValueTransferToFormData($merchantRelationshipSalesOrderThresholdTransfer, $data);
            }
        }

        $data[MerchantRelationshipThresholdType::FIELD_STORE_CURRENCY] = $this->formatStoreCurrencyRowValue(
            $storeTransfer,
            $currencyTransfer,
        );

        return $data;
    }

    /**
     * @return array<string>
     */
    protected function getStoreCurrencyList(): array
    {
        $storeWithCurrencyTransfers = $this->currencyFacade->getAllStoresWithCurrencies();
        $storeCurrencyList = [];

        foreach ($storeWithCurrencyTransfers as $storeWithCurrencyTransfer) {
            $storeTransfer = $storeWithCurrencyTransfer->getStore();

            foreach ($storeWithCurrencyTransfer->getCurrencies() as $currencyTransfer) {
                $storeCurrencyList[$this->formatStoreCurrencyRowLabel(
                    $storeTransfer,
                    $currencyTransfer,
                )] = $this->formatStoreCurrencyRowValue($storeTransfer, $currencyTransfer);
            }
        }

        return $storeCurrencyList;
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return string
     */
    protected function formatStoreCurrencyRowLabel(StoreTransfer $storeTransfer, CurrencyTransfer $currencyTransfer): string
    {
        return sprintf(
            static::FORMAT_STORE_CURRENCY_ROW_LABEL,
            $storeTransfer->getName(),
            $currencyTransfer->getName(),
            $currencyTransfer->getCode(),
        );
    }

    /**
     * @return array<string>
     */
    protected function getHardTypesList(): array
    {
        $hardTypesList = [];
        foreach ($this->formExpanderPlugins as $formExpanderPlugin) {
            if ($formExpanderPlugin->getThresholdGroup() === MerchantRelationshipSalesOrderThresholdGuiConfig::GROUP_HARD) {
                $hardTypesList[$formExpanderPlugin->getThresholdName()] = $formExpanderPlugin->getThresholdKey();
            }
        }

        return $hardTypesList;
    }

    /**
     * @return array<string>
     */
    protected function getHardMaximumTypesList(): array
    {
        $hardTypesList = [];
        foreach ($this->formExpanderPlugins as $formExpanderPlugin) {
            if ($formExpanderPlugin->getThresholdGroup() === MerchantRelationshipSalesOrderThresholdGuiConfig::GROUP_HARD_MAX) {
                $hardTypesList[$formExpanderPlugin->getThresholdName()] = $formExpanderPlugin->getThresholdKey();
            }
        }

        return $hardTypesList;
    }

    /**
     * @return array<string>
     */
    protected function getSoftTypesList(): array
    {
        $softTypesList = [];
        foreach ($this->formExpanderPlugins as $formExpanderPlugin) {
            if ($formExpanderPlugin->getThresholdGroup() === MerchantRelationshipSalesOrderThresholdGuiConfig::GROUP_SOFT) {
                $softTypesList[$formExpanderPlugin->getThresholdName()] = $formExpanderPlugin->getThresholdKey();
            }
        }

        return $softTypesList;
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return string
     */
    protected function formatStoreCurrencyRowValue(
        StoreTransfer $storeTransfer,
        CurrencyTransfer $currencyTransfer
    ): string {
        return sprintf(
            static::FORMAT_STORE_CURRENCY_ROW_VALUE,
            $storeTransfer->getName(),
            MerchantRelationshipSalesOrderThresholdGuiConfig::STORE_CURRENCY_DELIMITER,
            $currencyTransfer->getCode(),
        );
    }

    /**
     * @param int $idMerchantRelationship
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return array<\Generated\Shared\Transfer\MerchantRelationshipSalesOrderThresholdTransfer>
     */
    protected function getSalesOrderThresholdTransfers(
        int $idMerchantRelationship,
        StoreTransfer $storeTransfer,
        CurrencyTransfer $currencyTransfer
    ): array {
        return $this->merchantRelationshipSalesOrderThresholdFacade
            ->getMerchantRelationshipSalesOrderThresholds(
                $storeTransfer,
                $currencyTransfer,
                [$idMerchantRelationship],
            );
    }
}
