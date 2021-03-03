<?php


namespace Kl;


class UserPaymentDbTable
{
    private $storage = [];

    public function add(array $paymentData):bool
    {
        if (empty($paymentData['id'])) {
            $paymentData['id'] = count($this->storage) + 1;
        }

        $this->storage[] = $paymentData;

        return true;
    }
}
