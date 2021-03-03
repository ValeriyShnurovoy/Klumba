<?php


namespace Kl;

use Kl\Helpers\ArrayHelper;

/**
 * Class User
 * @package Kl
 */
class User
{
    public $id;

    public $balance;

    public $email;

    public function __construct(int $id, float $balance, string $email)
    {
        $this->id = $id;
        $this->balance = $balance;
        $this->email = $email;
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
