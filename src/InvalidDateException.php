<?php

namespace Opilo\Farsi;

use Exception;
use InvalidArgumentException;

class InvalidDateException extends InvalidArgumentException
{
    /**
     * @var Date|string
     */
    protected $date;

    /**
     * @param Date|string $date
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($date, $message = "", $code = 0, Exception $previous = null)
    {
        $this->date = $date;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Date|string
     */
    public function getDate()
    {
        return $this->date;
    }
}
