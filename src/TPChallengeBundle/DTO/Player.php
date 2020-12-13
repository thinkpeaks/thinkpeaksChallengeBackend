<?php

namespace App\TPChallengeBundle\DTO;

class Player implements DTOInterface
{
    /** @var string */
    private $nickname;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /** @var string */
    private $email;

    /** @var \DateTimeImmutable */
    private $createdDate;

    /** @var \DateTimeImmutable */
    private $lastPlayedDate;

    /** @var int */
    private $totalPlayed;

    /** @var int */
    private $highestScore;

    /** @var int */
    private $avgScore;

    /**
     * @param string $nickname
     * @return Player
     */
    public function setNickname(string $nickname): Player
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Player
     */
    public function setFirstname(string $firstname): Player
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @param string $lastname
     * @return Player
     */
    public function setLastname(string $lastname): Player
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @param string $email
     * @return Player
     */
    public function setEmail(string $email): Player
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $createdDate
     * @return Player
     */
    public function setCreatedDate(\DateTimeImmutable $createdDate): Player
    {
        $this->createdDate = $createdDate;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $lastPlayedDate
     * @return Player
     */
    public function setLastPlayedDate(\DateTimeImmutable $lastPlayedDate): Player
    {
        $this->lastPlayedDate = $lastPlayedDate;
        return $this;
    }

    /**
     * @param int $totalPlayed
     * @return Player
     */
    public function setTotalPlayed(int $totalPlayed): Player
    {
        $this->totalPlayed = $totalPlayed;
        return $this;
    }

    /**
     * @param int $highestScore
     * @return Player
     */
    public function setHighestScore(int $highestScore): Player
    {
        $this->highestScore = $highestScore;
        return $this;
    }

    /**
     * @param int $avgScore
     * @return Player
     */
    public function setAvgScore(int $avgScore): Player
    {
        $this->avgScore = $avgScore;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'nickname' => $this->nickname,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'created_date' => $this->createdDate->format('c'),
            'last_played_date' => $this->lastPlayedDate->format('c'),
            'highest_score' => $this->highestScore,
            'avg_score' => $this->avgScore,
            'total_played' => $this->totalPlayed,
        ];
    }
}
