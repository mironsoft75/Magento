<?php

namespace LearnStructure\MagentoStructure\Model;

use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;
use LearnStructure\MagentoStructure\Api\FormDataRepositoryInterface;
use LearnStructure\MagentoStructure\Model\ResourceModel\MagentoForm as ResourceMagentoForm;
use LearnStructure\MagentoStructure\Model\MagentoFormFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class FormDataRepository implements FormDataRepositoryInterface
{
    protected $resource;

    protected $magentoFormFactory;

    protected $dataObjectHelper;

    private $storeManager;

    public function __construct(
        ResourceMagentoForm $resource,
        MagentoFormFactory $magentoFormFactory,
        DataObjectHelper $dataObjectHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->magentoFormFactory = $magentoFormFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->storeManager = $storeManager;
    }

    public function save(FormDataInterface $magentoformdata)
    {
        if ($magentoformdata->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
           
            $magentoformdata->setStoreId($storeId);
        }
        try {
            $this->resource->save($magentoformdata);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the data: %1', $exception->getMessage()),
                $exception
            );
        }
        return $magentoformdata;
    }

    public function getById($id)
    {
        $magentoformdata = $this->magentoFormFactory->create();
        $magentoformdata->load($id);
       
        if (!$magentoformdata->getId()) {
            throw new NoSuchEntityException(__('Data with id "%1" does not exist.', $id));
        }
        return $magentoformdata;
    }

    public function delete(FormDataInterface $magentoformdata)
    {

       
        try {
            $this->resource->delete($magentoformdata);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the data: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($id)
{
    $magentoformdata = $this->getById($id);
    if ($magentoformdata->getId()) {
        try {
            $this->resource->delete($magentoformdata);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the data: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }
    return false;
}


public function update(FormDataInterface $magentoformdata)
{
    try {
        $this->resource->save($magentoformdata);
    } catch (\Exception $exception) {
        throw new CouldNotSaveException(__(
            'Could not update the data: %1',
            $exception->getMessage()
        ));
    }
    return $magentoformdata;
}

public function updateById($id)
{
    $magentoformdata = $this->getById($id);
    if ($magentoformdata->getId()) {
        try {
            $this->resource->save($magentoformdata);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not update the data: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }
    return false;
}

}
