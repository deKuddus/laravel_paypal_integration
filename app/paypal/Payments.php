<?php


namespace App\paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;

class Payments
{
    protected  $apiContext;
    public  function __construct()
    {
       $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id') ,
                config('services.paypal.secret')
            ));
    }

    /**
     * @return Details
     */
    protected function Details(): Details
    {
        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);
        return $details;
    }

    /**
     * @param Details $details
     * @return Amount
     */
    protected function Amount(): Amount
    {
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($this->Details());
        return $amount;
    }
}