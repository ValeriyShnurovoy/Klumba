<?php

use Kl\User;
use Kl\UserPaymentsService;

require_once 'vendor/autoload.php';

$userPaymentService = new UserPaymentsService();

$testData = require 'test-data.php';

foreach ($testData as $testDataRow) {
    list($user, $amount) = $testDataRow;
    
    try {
        $userModel = new User($user['id'], $user['balance'], $user['balance']);
        $userPaymentService->changeBalance($userModel, $amount);
        $expectedBalance = $user['balance'] + $amount;
        $resultBalance = $userModel->balance;
        $info = sprintf('User balance should be updated %s: %s', $expectedBalance, $expectedBalance);
        $result = assert($expectedBalance === $resultBalance, $info);
    } catch (Exception $e) {
        $result = false;
        $info = sprintf('User balance should be updated, exception: %s', $e->getMessage());
    }

    echo sprintf("[%s] %s\n", $result ? 'SUCCESS' : 'FAIL', $info);
}