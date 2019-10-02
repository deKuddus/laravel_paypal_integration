<?php


namespace App\paypal;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class CreateExecute extends  Payments
{

    public  function  execute()
    {

        $payment = $this->CreatePayment();

        $execution = $this->CreateExecute();

        $execution->addTransaction($this->Transaction());

        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }

    /**
     * @return Payment
     */
    protected function CreatePayment(): Payment
    {
        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        return $payment;
    }

    /**
     * @return PaymentExecution
     */
    protected function CreateExecute(): PaymentExecution
    {
        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));
        return $execution;
    }



    /**
     * @param Amount $amount
     * @return Transaction
     */
    protected function Transaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount());
        return $transaction;
    }
}