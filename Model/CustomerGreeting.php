<?php

namespace Magenest\Customapi\Model;

use Magenest\Customapi\Api\CustomerGreetingInterface;
use Magento\Customer\Model\CustomerRegistry;

class CustomerGreeting implements CustomerGreetingInterface
{
   /**
    * @var CustomerRegistry
    */

      protected $customerRegistry;
      protected $storeManager;
      protected $customerFactory;
      

   public function __construct(
        CustomerRegistry $customerRegistry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory)
   {
        $this->customerRegistry = $customerRegistry;
         $this->storeManager     = $storeManager;
        $this->customerFactory  = $customerFactory;
        
   }

   /**
    * Get customer's name by Customer ID and return greeting message.
    *
    * @api
    * @param int $customerId
    * @return \Magento\Customer\Api\Data\CustomerInterface
    * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
    * @throws \Magento\Framework\Exception\LocalizedException
    */

   public function sayHello($customerId)
   {
     //  $customerModel = $this->customerRegistry->retrieve($customerId);
     //  $name = $customerModel->getDataModel()->getFirstname();
     //  return "Hello " .$customerId['firstname'];


     $websiteId  = $this->storeManager->getWebsite()->getWebsiteId();

        // Instantiate object (this is the most important part)
        $customer   = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);

        // Preparing data for new customer
        $customer->setEmail($customerId['email']); 
        $customer->setFirstname($customerId['firstname']);
        $customer->setLastname($customerId['lastname']);
        $customer->setPassword($customerId['password']);

        // Save data
        $customer->save();
        $customer->sendNewAccountEmail();


        $customerData = $customer->setWebsiteId($websiteId)->loadByEmail($customerId['email']);
        $customerId = $customerData->getId();
        return "Customer ID" .$customerId;

   
}
}
