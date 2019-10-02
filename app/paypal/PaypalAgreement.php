<?php


namespace App\paypal;

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;


class PaypalAgreement extends Payments
{

    public  function  create($id){

        return redirect($this->agreement($id));


    }

    /**
     * @return Agreement
     */
    protected function agreement($id): Agreement
    {
        $agreement = new Agreement();

        $agreement->setName('Base Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate('2019-06-17T9:45:04Z');

        $agreement->setPlan($this->Plan($id));

        $agreement->setPayer($this->Payer());

        $agreement->setShippingAddress($this->ShipingAddress());

        $agreement = $agreement->create($this->apiContext);

        return  $agreement->getApprovalLink();


    }

    /**
     * @param $id
     * @return Plan
     */
    protected function Plan($id): Plan
    {
        $plan = new Plan();
        $plan->setId($id);
        return $plan;
    }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @return ShippingAddress
     */
    protected function ShipingAddress(): ShippingAddress
    {
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        return $shippingAddress;
    }

}