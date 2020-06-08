<?php 
namespace DGvai\ISMS;

/**
 *  Laravel Notification Channel for ISMS (Bangladesh)
 *  Package Developped by:
 * 
 *  ** Jalal Uddin                  **
 *  ** www.github.com/dgvai         **
 *  ** www.linkedin.com/in/dgvai    **
 * 
 *  LICENSE MIT
 */

class ISMS 
{
    /**
     *  The message body to be sent to the user
     */

    protected $message;

    /**
     * primary contruction
     */

    public function __construct(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * retrive message body
     */

    public function message()
    {
        return $this->message;
    }
}