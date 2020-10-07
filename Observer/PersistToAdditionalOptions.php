<?php

namespace Iweb\Countdown\Observer;

class PersistToAdditionalOptions implements \Magento\Framework\Event\ObserverInterface
{
    protected $optionFactory;
    protected $serializer;

    public function __construct(
        \Magento\Quote\Model\Quote\Item\OptionFactory $optionFactory,
        \Magento\Framework\Serialize\Serializer\Json $serializer
    ) {
        $this->optionFactory = $optionFactory;
        $this->serializer = $serializer;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote\Item $quoteItem */
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $product = $quoteItem->getProduct();
        
        $releaseDate = $product->getReleaseDate();
        $currentDateTime = (new \DateTime('now'))->format('Y-m-d H:i:s');
        
        if (   !$product
            || !$releaseDate
            || $releaseDate < $currentDateTime
            || $product->getParentId()
        ) {
            return;
        }

        $releaseDateAttribute = $product->getResource()->getAttribute('release_date');

        $attributes = $quoteItem->getOptionByCode('attributes');
        if ($attributes && isset($attributes[$releaseDateAttribute->getId()])) {
            return;
        }

        $additionalOptions = $quoteItem->getOptionByCode('additional_options');
        if ($additionalOptions) {
            $values = $this->serializer->unserialize($additionalOptions->getValue());

            foreach ($values as $_value) {
                if ($_value['label'] == $releaseDateAttribute->getStoreLabel()) {
                    return; // ...so the bespoke "Release Date" attribute value isn't duplicated upon logging in
                }
            }
        } else {
            $values = [];

            /** @var \Magento\Quote\Model\Quote\Item\Option $additionalOptions */
            $additionalOptions = $this->optionFactory->create()
                ->setProductId($product->getId())
                ->setCode('additional_options')
                ->setValue($attributes);

            $quoteItem->addOption($additionalOptions);
        }

        $values[] = [
            'label' => __('Pre-Order'),
            'value' => __('Yes')
        ];

        $additionalOptions->setValue($this->serializer->serialize($values));
    }
}
