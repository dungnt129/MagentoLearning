<?php
/**
 * model class to work with join
 */
namespace Dmit\Stripe\Model;

use Magento\Framework\DataObject\IdentityInterface;

/**
 * JoinModel Model.
 */
class JoinModel extends \Magento\Framework\Model\AbstractModel
    implements \Dmit\Stripe\Api\Data\JoinModelInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * Stripe JoinModel cache tag.
     */
    const CACHE_TAG = 'my_table_join_test';

    /**
     * @var string
     */
    protected $_cacheTag = 'my_table_join_test';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'my_table_join_test';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Dmit\Stripe\Model\ResourceModel\JoinModel');
    }

    /**
     * Load object data.
     *
     * @param int|null $id
     * @param string $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteReasons();
        }

        return parent::load($id, $field);
    }

    /**
     * Load No-Route JoinModel.
     *
     * @return \Dmit\Stripe\Model\JoinModel
     */
    public function noRouteReasons()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * Get ID.
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Dmit\Stripe\Api\Data\JoinModelInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}