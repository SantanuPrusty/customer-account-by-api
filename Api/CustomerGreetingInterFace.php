<?php
namespace Magenest\Customapi\Api;

interface CustomerGreetingInterface
{
  /**
* POST for test api
* @param string[] $customerId
* @return string
*/
   public function sayHello($customerId);
   


}