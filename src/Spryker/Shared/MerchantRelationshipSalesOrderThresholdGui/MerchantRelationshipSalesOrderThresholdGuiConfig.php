<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\MerchantRelationshipSalesOrderThresholdGui;

interface MerchantRelationshipSalesOrderThresholdGuiConfig
{
    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::GROUP_HARD
     *
     * @var string
     */
    public const GROUP_HARD = 'Hard';

    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::GROUP_SOFT
     *
     * @var string
     */
    public const GROUP_SOFT = 'Soft';

    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::STRATEGY_KEY
     *
     * @var string
     */
    public const HARD_TYPE_STRATEGY = 'hard-minimum-threshold';

    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::STRATEGY_KEY
     *
     * @var string
     */
    public const SOFT_TYPE_STRATEGY_MESSAGE = 'soft-minimum-threshold';

    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::STRATEGY_KEY
     *
     * @var string
     */
    public const SOFT_TYPE_STRATEGY_FIXED = 'soft-minimum-threshold-fixed-fee';

    /**
     * @api
     *
     * @deprecated Will be removed in the next major.
     *
     * @uses \Spryker\Shared\SalesOrderThreshold\SalesOrderThresholdConfig::STRATEGY_KEY
     *
     * @var string
     */
    public const SOFT_TYPE_STRATEGY_FLEXIBLE = 'soft-minimum-threshold-flexible-fee';
}
