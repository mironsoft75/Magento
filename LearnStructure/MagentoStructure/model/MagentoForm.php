<?php
namespace LearnStructure\MagentoStructure\Model;

use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class MagentoForm extends AbstractModel implements FormDataInterface, IdentityInterface
{
    protected $_idFieldName = 'id';
    const CACHE_TAG = 'Learn_magento';
    protected $_cacheTag = self::CACHE_TAG;

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    protected function _construct()
    {
        $this->_init(\LearnStructure\MagentoStructure\Model\ResourceModel\MagentoForm::class);
    }


     
   
    public function getId()
	{
		return parent::getData(self::ID);
	}

	public function getName()
	{
		return parent::getData(self::NAME);
	}
    
	public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
      
        public function setName()
        {
           
            return $this->setData(self::NAME, $name);
        }



       
    
}
