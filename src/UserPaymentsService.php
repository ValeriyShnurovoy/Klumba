<?php


namespace Kl;


class UserPaymentsService
{
    const AMOUNT_TYPE_IN = 'in';
    const AMOUNT_TYPE_OUT = 'out';

    private $userPaymentsDbTable;

    private $userDbTable;

    public function getUserPaymentsDbTable():UserPaymentDbTable
    {
        if (!$this->userPaymentsDbTable) {
            $this->userPaymentsDbTable = new UserPaymentDbTable();
        }

        return $this->userPaymentsDbTable;
    }

    public function getUserDbTable():UserDbTable
    {
        if (!$this->userDbTable) {
            $this->userDbTable = new UserDbTable();
        }

        return $this->userDbTable;
    }

    /**
     * @param User $user
     * @param float $amount
     * @return bool
     * @throws \Exception
     */
    public function  changeBalance(User $user, float $amount):bool
    {
        $userDbTable = $this->getUserDbTable();
        $userPaymentsDbTable = $this->getUserPaymentsDbTable();
        $paymentType = $amount >= 0 ? self::AMOUNT_TYPE_IN : self::AMOUNT_TYPE_OUT;
        $payment = new UserPayment($user->id, $paymentType, $user->balance, abs($amount));

        // add payment transaction
        if (!$userPaymentsDbTable->add($payment->toArray())) {
            $msg = sprintf('Failed to pop up user balance');
            error_log($msg);
            throw new \Exception($msg);
        }

        $user->balance += $amount;

        // send email
        $this->sendEmail($user->email);

        // update user balance in db
        return $userDbTable->updateUser($user->toArray());
    }

    /**
     * @param string $userEmail
     * @return bool
     */
    public function sendEmail(string $userEmail):bool
    {
        $adminEmail = 'admin@test.com';
        $subject = 'Balance update';
        $message = 'Hello! Your balance has been successfully updated!';
        $headers = 'From: ' . $adminEmail . "\r\n" .
            'Reply-To: ' . $adminEmail . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        return mail($userEmail, $subject, $message, $headers);
    }
}
