<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInvite
 *
 * @ORM\Table(name="user_invite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserInviteRepository")
 */
class UserInvite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=20)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtCreated", type="datetime")
     */
    private $dtCreated;

    /**
     * @var User
     * 
     * @ORM\OneToOne(targetEntity="User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $inviter;

    /**
     * This method doesn't do anything but is here to ensure logic. Can be modified.
     */
    public function isValid() {
        return true;
    }

    /**
     * GETTER and SETTERS
     */

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UserInvite
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return UserInvite
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set dtCreated
     *
     * @param \DateTime $dtCreated
     *
     * @return UserInvite
     */
    public function setDtCreated($dtCreated)
    {
        $this->dtCreated = $dtCreated;

        return $this;
    }

    /**
     * Get dtCreated
     *
     * @return \DateTime
     */
    public function getDtCreated()
    {
        return $this->dtCreated;
    }

    public function getInviter() {return $this->inviter;}
    public function setInviter($inviter) {$this->inviter = $inviter;}

    public function getUser() {return $this->user;}
    public function setUser($user) {$this->user = $user;}
}

