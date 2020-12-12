<?php

namespace App\TPChallengeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\TPChallengeBundle\Traits\TimestampableTrait;


/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity(repositoryClass="App\TPChallengeBundle\Repository\ScoreRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Score
{

    use TimestampableTrait;

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
     * @ORM\Column(name="nickName", type="string", length=255)
     */
    private $nickName;


    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var bool
     *
     * @ORM\Column(name="isSpecialGuest", type="boolean")
     */
    private $isSpecialGuest;

    /**
     * @var bool
     *
     * @ORM\Column(name="whitoutFrontend", type="boolean", nullable=true)
     */
    private $whitoutFrontend;


    /**
     * @var bool
     *
     * @ORM\Column(name="isArchived", type="boolean", nullable=false)
     */
    private $isArchived = false;


    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", nullable=false)
     */
    private $uniqueId;

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId(string $uniqueId)
    {
        $this->uniqueId = $uniqueId;
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
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Score
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
     * @return Score
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Score
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
     * Set score
     *
     * @param integer $score
     *
     * @return Score
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set isSpecialGuest
     *
     * @param boolean $isSpecialGuest
     *
     * @return Score
     */
    public function setIsSpecialGuest($isSpecialGuest)
    {
        $this->isSpecialGuest = $isSpecialGuest;

        return $this;
    }

    /**
     * Get isSpecialGuest
     *
     * @return bool
     */
    public function getIsSpecialGuest()
    {
        return $this->isSpecialGuest;
    }

    /**
     * Set whitoutFrontend
     *
     * @param boolean $whitoutFrontend
     *
     * @return Score
     */
    public function setWhitoutFrontend($whitoutFrontend)
    {
        $this->whitoutFrontend = $whitoutFrontend;

        return $this;
    }

    /**
     * Get whitoutFrontend
     *
     * @return bool
     */
    public function getWhitoutFrontend()
    {
        return $this->whitoutFrontend;
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
    }


    /**
     * @ORM\PrePersist
     */
    public function setUniqueIdValue()
    {
        $this->uniqueId = uniqid();

    }


}

