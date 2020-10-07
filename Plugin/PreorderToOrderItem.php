<?php

namespace Iweb\Countdown\Plugin;

class PreorderToOrderItem 
{
    protected $serializer;
    
    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $serializer
    )
    {
       $this->serializer = $serializer; 
    }

    public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        callable $proceed,
        \Magento\Quote\Model\Quote\Item $item,
        $data = []
    )
    {
        $orderItem = $proceed($item, $data);
        $additionalOptions = $item->getOptionByCode('additional_options');
        
        $releaseDate = $product->getReleaseDate();
        $currentDateTime = (new \DateTime('now'))->format('Y-m-d H:i:s');
        
        if (   !$product
            || !$releaseDate
            || $releaseDate < $currentDateTime
            || $product->getParentId()
        ) {
            return;
        }
        
        if ($additionalOptions) {
            $options = $orderItem->getProductOptions();
            $options['additional_options'] = $this->serializer->unserialize($additionalOptions->getValue());
            $orderItem->setProductOptions($options);
        }
        
        return $orderItem;
    }
}
