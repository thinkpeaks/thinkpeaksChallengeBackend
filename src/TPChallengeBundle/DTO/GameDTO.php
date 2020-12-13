<?php

namespace App\TPChallengeBundle\DTO;

class GameDTO implements DTOInterface
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
     * @return GameDTO
     */
    public function setUniqueId(string $uniqueId): GameDTO
    {
        $this->uniqueId = $uniqueId;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $date
     * @return GameDTO
     */
    public function setDate(\DateTimeImmutable $date): GameDTO
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param string $playerNickname
     * @return GameDTO
     */
    public function setPlayerNickname(string $playerNickname): GameDTO
    {
        $this->playerNickname = $playerNickname;
        return $this;
    }

    /**
     * @param int $score
     * @return GameDTO
     */
    public function setScore(int $score): GameDTO
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
