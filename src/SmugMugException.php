<?php

namespace sklyukin\PhpSmugMug;

class SmugMugException extends \Exception
{
    /** @var string */
    protected $message = 'Unknown exception';
    /** @var integer */
    protected $code;

    /** @var SmugMugException */
    protected $previous;

    public function __construct($message = null, $code = 0, SmugMugException $previous = null)
    {
        $this->code = $code;
        if (!is_null($message)) {
            $this->message = $message;
        }
        $this->previous = $previous;
        parent::__construct($this->message, $this->code, $this->previous);
    }

    /**
     * Formatted string for display
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . ': [' . $this->code . ']: ' . $this->message;
    }
}
