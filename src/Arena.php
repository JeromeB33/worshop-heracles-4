<?php

namespace App;

use Exception;

class Arena 
{
    private array $monsters;
    private Hero $hero;
    private string $direction;

    private int $size = 10;

    public function __construct(Hero $hero, array $monsters)
    {
        $this->hero = $hero;
        $this->monsters = $monsters;
    }

    public function getDistance(Fighter $startFighter, Fighter $endFighter): float
    {
        $Xdistance = $endFighter->getX() - $startFighter->getX();
        $Ydistance = $endFighter->getY() - $startFighter->getY();
        return sqrt($Xdistance ** 2 + $Ydistance ** 2);
    }

    public function touchable(Fighter $attacker, Fighter $defenser): bool 
    {
        return $this->getDistance($attacker, $defenser) <= $attacker->getRange();
    }

    public function move(Fighter $fighter, string $direction)
    {
        $max = $this->getSize() - 1;
       $x = $fighter->getX();
       $y = $fighter->getY();
            $monsters = $this->getMonsters();
        if($direction == "N"){
            $x --;
        } elseif ($direction == "S"){
            $x ++;
        } elseif ($direction == "E"){
            $y ++;
        }elseif($direction == "W"){
            $y --;
        }

            foreach ($monsters as $monster){
                if ($x == $monster->getX() && $y == $monster->getY()){
                    throw new Exception('case occupée');}}

                if($x > $max || $y > $max || $x < 0 || $y < 0){
                    throw new Exception('sortie de carte');
                }
        
                        $fighter->setX($x);
                        $fighter->setY($y);
                    

}

    public function battle(int $id)
    {
        $hero = $this->getHero();
        $monsters = $this->getMonsters();
        if($this->touchable($hero, $monsters[$id]) == true)
        {
            $hero->fight($monsters[$id]);

        }else{
            throw new Exception('ennemi trop loin');
        }
        if($this->touchable($monsters[$id], $hero) == true)
        {
            $monsters[$id]->fight($hero);
        }else{
            throw new Exception('hero trop loin');
        }
        if($monsters[$id]->getLife()<=0)
        {
            $hero->setExperience($hero->getExperience() + $monsters[$id]->getExperience());
            unset($monsters[$id]);
            $this->setMonsters($monsters);
        }
    }
    /**
     * Get the value of monsters
     */ 
    public function getMonsters(): array
    {
        return $this->monsters;
    }

    /**
     * Set the value of monsters
     *
     */ 
    public function setMonsters($monsters): void
    {
        $this->monsters = $monsters;
    }

    /**
     * Get the value of hero
     */ 
    public function getHero(): Hero
    {
        return $this->hero;
    }

    /**
     * Set the value of hero
     */ 
    public function setHero($hero): void
    {
        $this->hero = $hero;
    }

    /**
     * Get the value of size
     */ 
    public function getSize(): int
    {
        return $this->size;
    }
}