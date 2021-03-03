<?php


namespace Kl;

use Kl\Helpers\ArrayHelper;

class UserPayment
{
    public $id;

    public $userId;

    public $type;

    public $balanceBefore;

    public $amount;

    public function __construct(int $userId, string $type, float $balanceBefore, float $amount, ?int $id = null)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->type = $type;
        $this->balanceBefore = $balanceBefore;
        $this->amount = $amount;
    }

    /**
     * @param string $conversionRule
     * @return array
     */
    public function toArray(string $conversionRule = 'underscore'):array
    {
        $vars = get_object_vars($this);
        return ArrayHelper::toArray($vars, $conversionRule);
    }
}