<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Persistence;

use Orm\Zed\MerchantRelationship\Persistence\SpyMerchantRelationshipQuery;
use Orm\Zed\MerchantRelationshipSalesOrderThreshold\Persistence\SpyMerchantRelationshipSalesOrderThresholdQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\MerchantRelationshipSalesOrderThresholdGuiDependencyProvider;

/**
 * @method \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\MerchantRelationshipSalesOrderThresholdGuiConfig getConfig()
 * @method \Spryker\Zed\MerchantRelationshipSalesOrderThresholdGui\Persistence\MerchantRelationshipSalesOrderThresholdGuiRepositoryInterface getRepository()
 */
class MerchantRelationshipSalesOrderThresholdGuiPersistenceFactory extends AbstractPersistenceFactory
{
    public function getMerchantRelationshipPropelQuery(): SpyMerchantRelationshipQuery
    {
        return $this->getProvidedDependency(MerchantRelationshipSalesOrderThresholdGuiDependencyProvider::PROPEL_QUERY_MERCHANT_RELATIONSHIP);
    }

    public function getMerchantRelationshipSalesOrderThresholdPropelQuery(): SpyMerchantRelationshipSalesOrderThresholdQuery
    {
        return $this->getProvidedDependency(MerchantRelationshipSalesOrderThresholdGuiDependencyProvider::PROPEL_QUERY_MERCHANT_RELATIONSHIP_SALES_ORDER_THRESHOLD);
    }
}
