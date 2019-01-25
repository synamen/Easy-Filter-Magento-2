<?php

namespace Synamen\EasyFilter\Controller\Index;

use \Magento\Framework\App\Action\Action;

class Index extends Action
{
    public function execute()
    {
    	$allData = $this->getRequest()->getParam('alldata');

		$query = $this->getRequest()->getParam('query');

		$currenthtml = $this->getRequest()->getParam('currenthtml');

		$result_labels = array();

		foreach($allData as $key => $item)
		{
			if(stripos($item, $query) !== false)
			{
				$result_labels[$key] = $item;
			}
		}
		
		$htmlArray = explode('<li class="item">',$currenthtml);

		$result = array();
		
		
		foreach($result_labels as $key => $result_label)
		{
			foreach($htmlArray as $li)
			{
				if(strpos($li, $result_label) !== false)
				{
					$result[] = '<li class="item">'.$li;
				}
			}
		}
		
		$unique_result = array_unique($result);
		
		$resultHtml = implode("", $unique_result);

		$this->getResponse()->representJson(
            $this->_objectManager->get(\Magento\Framework\Json\Helper\Data::class)->jsonEncode($resultHtml)
        );
    }
}