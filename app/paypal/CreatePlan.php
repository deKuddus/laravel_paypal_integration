<?php


namespace App\paypal;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Common\PayPalModel;


class CreatePlan extends Payments

{
    public  function  execute()
    {
        $plan = $this->Plan();


        $paymentDefinition = $this->PaymentDefinition();

        $chargeModel = $this->ChargingModel();

        $paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = $this->MercentPreferences();

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $output = $plan->create($this->apiContext);

        dd($output);



    }

    /**
     * @return Plan
     */
    protected function Plan(): Plan
    {
        $plan = new Plan();
        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');
        return $plan;
    }

    /**
     * @return PaymentDefinition
     */
    protected function PaymentDefinition(): PaymentDefinition
    {
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));
        return $paymentDefinition;
    }

    /**
     * @return ChargeModel
     */
    protected function ChargingModel(): ChargeModel
    {
        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
        return $chargeModel;
    }

    /**
     * @return MerchantPreferences
     */
    protected function MercentPreferences(): MerchantPreferences
    {
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(config('services.paypal.url.executeAgreement.success'))
            ->setCancelUrl(config('services.paypal.url.executeAgreement.failur'))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));
        return $merchantPreferences;
    }


    public  function  planList()
    {
        $params = array('page_size' => '2');
        $planList = Plan::all($params, $this->apiContext);
        return $planList ;
    }


    public function planDetails($id)
    {
        $plan = Plan::get($id, $this->apiContext);
        return $plan;

    }

    public  function  activate($id)
    {
        $createdPlan = $this->planDetails($id);
        $patch = new Patch();

        $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $createdPlan->update($patchRequest, $this->apiContext);

        $plan = Plan::get($createdPlan->getId(), $this->apiContext);
    }
}