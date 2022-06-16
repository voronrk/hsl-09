<?php

namespace App\Services;

/**
 * Time counter class
 */
class TimeCounter
{

    public float $timeStart;
    public float $timeFinish;
    public float $duration;

    /**
     * Save and return timestamp of begin (s)
     *
     * @return float
     */
    public function start(): float
    {
        $this->timeStart = microtime(true);
        return $this->timeStart;
    }

    /**
     * Save and return timestamp for end (s) and calculate duration (s) with saving to property
     *
     * @return float
     */
    public function finish(): float
    {
        $this->timeFinish = microtime(true);
        $this->duration = $this->timeFinish - $this->timeStart;
        return $this->timeFinish;
    }
}
