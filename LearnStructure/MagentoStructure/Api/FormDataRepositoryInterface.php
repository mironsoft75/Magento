<?php
namespace LearnStructure\MagentoStructure\Api;

use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;

interface FormDataRepositoryInterface
{
	public function save(FormDataInterface $magentoformdata);

    public function getById($id);

    public function delete(FormDataInterface $magentoformdata);

    public function deleteById($id);


    public function update(FormDataInterface $magentoformdata);

    public function updateById($id);
}

    

?>
