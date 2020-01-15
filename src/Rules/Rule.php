<?php

namespace GOL\Rules;

use GetOpt\GetOpt;
use GetOpt\Option;
use GOL\Boards\Field;

/**
 * Base class for Additional Rules.
 *
 * use apply() to apply the rule.
 * @codeCoverageIgnore
 */
abstract class Rule
{
    /**
     * @param Field $_field Cell to check.
     * @return bool cells state in the next generation.
     */
    abstract public function apply(Field $_field): bool;

    /**
     * Register all optional parameters of an Input, if any.
     * @return Option[] Array of options.
     */
    public function register(): array
    {
        return [];
    }

    /**
     * Returns the description of the Rule.
     * This is used to list all rules if the argument ruleList is set.
     * @return string description.
     */
    public function description(): string
    {
        return "";
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @param GetOpt $getOpt Option manager.
     */
    public function initialize(GetOpt $getOpt)
    {
    }

}