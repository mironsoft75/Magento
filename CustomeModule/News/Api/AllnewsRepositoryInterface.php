<?php
namespace CustomeModule\News\Api;

interface AllnewsRepositoryInterface
{
	public function save(\CustomeModule\News\Api\Data\AllnewsInterface $news);

    public function getById($newsId);

    public function delete(\CustomeModule\News\Api\Data\AllnewsInterface $news);

    public function deleteById($newsId);
}
?>