<?php
namespace LearnStructure\MagentoStructure\Api\Data;

interface FormDataInterface
{
	const ID = 'id';
    const NAME = 'name';

	public function getId();

	public function getName();

	
   
	public function setId(?int $id);

	public function setName();
}
