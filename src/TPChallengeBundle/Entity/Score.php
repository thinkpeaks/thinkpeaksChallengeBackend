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
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     * @return Score
     */
    public function setUniqueId(string $uniqueId): Score
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getNickName(): string
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     * @return Score
     */
    public function setNickName(string $nickName): Score
    {
        $this->nickName = $nickName;
        return $this;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Score
     */
    public function setFirstName(string $firstName): Score
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Score
     */
    public function setLastName(string $lastName): Score
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Score
     */
    public function setEmail(string $email): Score
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Score
     */
    public function setScore($score): Score
    {
        $this->score = $score;
        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore(): int
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
    public function setIsSpecialGuest($isSpecialGuest): Score
    {
        $this->isSpecialGuest = $isSpecialGuest;
        return $this;
    }

    /**
     * Get isSpecialGuest
     *
     * @return bool
     */
    public function getIsSpecialGuest(): bool
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
    public function setWhitoutFrontend(bool $whitoutFrontend): Score
    {
        $this->whitoutFrontend = $whitoutFrontend;
        return $this;
    }

    /**
     * Get whitoutFrontend
     *
     * @return bool
     */
    public function getWhitoutFrontend(): bool
    {
        return $this->whitoutFrontend;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     * @return Score
     */
    public function setIsArchived(bool $isArchived): Score
    {
        $this->isArchived = $isArchived;
        return $this;
    }


    /**
     * @ORM\PrePersist
     */
    public function setUniqueIdValue()
    {
        $this->uniqueId = uniqid();
    }


}

