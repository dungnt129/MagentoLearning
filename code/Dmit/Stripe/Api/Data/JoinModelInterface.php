<?php
/**
 * Join table data interface
 */

namespace Dmit\Stripe\Api\Data;

/**
 * Stripe JoinModel interface.
 *
 * @api
 */
interface JoinModelInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID = 'entity_id';
    /**#@-*/

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Dmit\Stripe\Api\Data\ReasonsInterface
     */
    public function setId($id);
}