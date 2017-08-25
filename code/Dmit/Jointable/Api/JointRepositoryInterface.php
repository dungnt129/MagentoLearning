<?php
namespace Dmit\Jointable\Api;

use Dmit\Jointable\Api\Data\JointInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;

interface JointRepositoryInterface 
{
    public function save(JointInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(JointInterface $page);

    public function deleteById($id);
}
