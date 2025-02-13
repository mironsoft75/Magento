<?php
namespace CustomeModule\News\Block;

Class ViewNews extends \Magento\Framework\View\Element\Template
{
	protected $allNewsFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\CustomeModule\News\Model\AllnewsFactory $allNewsFactory
	){
		parent::__construct($context);
		$this->allNewsFactory = $allNewsFactory;
	}
	
	public function getNews()
	{
		$id = $this->getRequest()->getParam('id');
		$news = $this->allNewsFactory->create()->load($id);
		
		return $news;
	}
	
	protected function _prepareLayout(){
		
		parent::_prepareLayout();
		
		$news = $this->getNews();
		$this->pageConfig->getTitle()->set($news->getTitle());
		
        return $this;
	}
}
?>
