<?php
namespace App\Service;

use App\Entity\StockMovement;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Summary of StockService
 * 
 *  @author FIKA <pofinet@outlook.com>
 */
class StockService{
    
    private $em;
    private $referenceGenerator;
    public function __construc(EntityManagerInterface $em,ReferenceGeneratorService $generator){
        $this->em = $em;
        $this->referenceGenerator = $generator;
    }

    public function createStockMovement(StockMovement $movement){
        $movement->setReference($this->referenceGenerator->generate());
        $movement->setCreatedAt(new \DateTimeImmutable());
        $this->em->persist($movement);
        $this->em-flush();
    }

    // public function retrieveFromStock(StockMovement $movement){
    //     $movement->setReference($this->referenceGenerator->generate());
    //     $movement->setCreatedAt(new \DateTimeImmutable());
    //     $this->em->persist($movement);
    // }
}