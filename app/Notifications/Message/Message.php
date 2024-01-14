<?php
/**
 * Created by PhpStorm.
 * User: SHAREEF
 * Date: 3/21/2018
 * Time: 2:29 PM
 */

namespace App\Notifications\Message;

/**
 * This Class should hold any notification message
 * So, you are free to add any needed attribute to be held about the message
 */
class Message
{
    /**
     * The title content.
     *
     * @var string
     */
    public $title;

    /**
     * The message content.
     *
     * @var string
     */
    public $message;

    /**
     * The player id.
     * Used for OneSignal (Application Notifications Provider)
     *
     * @var string
     */
    public $player_id;

    /**
     * The notification data.
     *
     * @var array
     */
    public $data;

    /**
     * is the notification public
     *
     * @var boolean
     */
    public $isPublic = false;

    /**
     * The error message format.
     *
     * @var string
     */
    public $errorFormat = 'string';

    /**
     * The username.
     *
     * @var string
     */
    public $username;

    /**
     * The password.
     *
     * @var string
     */
    public $password;

    /**
     * The numbers that the message will be sent to.
     *
     * @var string
     */
    public $numbers;

    /**
     * The name of the sender.
     *
     * @var string
     */
    public $sender;


    /**
     * Create a new message instance.
     *
     * You are free to pass any needed params to constructor
     * @param  string $message
     *
     */
    public function __construct()
    {
    }

    /**
     * Set the username.
     *
     * @param  string $username
     * @return $this
     */
    public function username($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the password.
     *
     * @param  string $password
     * @return $this
     */
    public function password($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set numbers.
     *
     * @param  string $numbers
     * @return $this
     */
    public function numbers($numbers)
    {
        $this->numbers = $numbers;

        return $this;
    }


    /**
     * Set the name of the sender.
     *
     * @param  string $sender
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the title content.
     *
     * @param  string $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the message content.
     *
     * @param  string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the player id
     *
     * @param  string $player_id
     * @return $this
     */
    public function player($player_id)
    {
        $this->player_id = $player_id;

        return $this;
    }

    /**
     * Set the notification data
     *
     * @param  array $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the notification destination
     *
     * @param  boolean $isPublic
     * @return $this
     */
    public function isPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function setErrorFormat($errorFormat)
    {
        $this->errorFormat = $errorFormat;

        return $this;
    }
}
