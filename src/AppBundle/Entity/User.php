<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(name="firstName", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=64)
     */
    private $pwd;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPwd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtCreated", type="datetimetz")
     */
    private $dtCreated;

     /**
     * @ORM\ManyToMany(targetEntity="SecurityGroup", inversedBy="users")
     *
     */
    private $securityGroups;

    /**
     * @var smallint
     * 
     * 0 = invited, 1 = activated, 2 = locked
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /* UserInterface methods */
    public function getRoles()
    {
        $groups = array_map(function($group){if($group != null) return $group->getRole();}, $this->securityGroups->toArray());
        $groups[] = 'ROLE_USER';
        return $groups;
    }

    public function getSecurityGroups()
    {
        return $this->securityGroups;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {

    }

    /* Serialize */
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->pwd
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->pwd
        ) = unserialize($serialized);
    }


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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /*
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set pwd
     *
     * @param string $pwd
     *
     * @return User
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->getPwd();
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function setPassword($pwd)
    {
        return $this->setPwd($pwd);
    }

    public function getPlainPassword()
    {
        return $this->plainPwd;
    }

    public function setPlainPassword($pwd)
    {
        $this->plainPwd = $pwd;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set dtCreated
     *
     * @param \DateTime $dtCreated
     *
     * @return User
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

    public function getState() {return $this->state;}
    public function setState($state) {$this->state = $state;}

    /**
     * WARNING - DO NOT USE : call SecurityGroup->addUser() instead
     */
    public function addSecurityGroup(SecurityGroup $sg) {
        $this->securityGroups->add($sg);
    }

    /**
     * WARNING - DO NOT USE : call SecurityGroup->removeUser() instead
     */
    public function removeSecurityGroup(SecurityGroup $sg) {
        $this->securityGroups->removeElement($sg);
    }
}

