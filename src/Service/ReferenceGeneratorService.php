<?php
namespace App\Service;


/**
 * Summary of ReferenceGeneratorService
 * Cette class permet de generer des references uniques sous la forme de snowflake id.
 * Le constructeur prend en parametre l'id de la machine qui est valeur entre 1 et 1023 et l'epoch 
 * qui a ete racourci ici au 01-01-2020 00:00:00.
 * @author FIKA <pofinet@outlook.com>
 */
class ReferenceGeneratorService{

    /**
     * Summary of epoch
     * @var int
     */
    private int $epoch;
    /**
     * Summary of machineId
     * @var int
     */
    private int $machineId;
    /**
     * Summary of sequence
     * @var int
     */
    private int $sequence = 0;
    /**
     * Summary of lastTimestamp
     * @var int
     */
    private int $lastTimestamp = -1;

    public function __construct(int $machineId = 1, int $customEpoch = 1577836800000)
    {
        if ($machineId < 0 || $machineId > 1023) {
            throw new \InvalidArgumentException('Machine ID must be between 0 and 1023');
        }
        $this->machineId = $machineId;
        $this->epoch = $customEpoch;
    }

    /**
     * Summary of generate
     * Cette methode genere et renvoi un nouveau snowflake id 
     * @return int
     */
    public function generate(): int
    {
        $timestamp = $this->currentTimeMillis();

        if ($timestamp === $this->lastTimestamp) {
            $this->sequence = ($this->sequence + 1) & 0xFFF; // 12 bits (4096)
            if ($this->sequence === 0) {
                $timestamp = $this->waitNextMillis($timestamp);
            }
        } else {
            $this->sequence = 0;
        }

        $this->lastTimestamp = $timestamp;

        return (($timestamp - $this->epoch) << 22) |
               ($this->machineId << 12) |
               $this->sequence;
    }

    /**
     * Summary of waitNextMillis
     * Cette methode renvoi de timestamps suivant. Elle prend en parametre le timestamp actuel et 
     *  boucle jusqu'au prochain timestamp
     * @param int $currentTimestamp
     * @return int
     */
    private function waitNextMillis(int $currentTimestamp): int
    {
        $timestamp = $this->currentTimeMillis();
        while ($timestamp <= $currentTimestamp) {
            usleep(1_000); // attendre 1 ms
            $timestamp = $this->currentTimeMillis();
        }
        return $timestamp;
    }


    /**
     * Summary of currentTimeMillis
     * Cette methode permet de renvoyer le timestamp actuel en milliseconde
     * @return int
     */
    private function currentTimeMillis(): int
    {
        return (int)(microtime(true) * 1000);
    }
}