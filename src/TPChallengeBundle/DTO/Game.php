<?php

namespace App\TPChallengeBundle\DTO;

class Game implements DTOInterface
{
    /** @var string */
    private $uniqueId;

    /** @var \DateTimeImmutable */
    private $date;

    /** @var string */
    private $playerNickname;

    /** @var int */
    private $score;

    /**
     * @param string $uniqueId
     * @return Game
     */
    public function setUniqueId(string $uniqueId): Game
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $date
     * @return Game
     */
    public function setDate(\DateTimeImmutable $date): Game
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param string $playerNickname
     * @return Game
     */
    public function setPlayerNickname(string $playerNickname): Game
    {
        $this->playerNickname = $playerNickname;
        return $this;
    }

    /**
     * @param int $score
     * @return Game
     */
    public function setScore(int $score): Game
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'unique_id' => $this->uniqueId,
            'date' => $this->date->format('c'),
            'player_nickname' => $this->playerNickname,
            'score' => $this->score,
        ];
    }
}
