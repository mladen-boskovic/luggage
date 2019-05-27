<?php

class SuperKlasa
{
    protected $baza;

    //region Get i Set
    protected function getBaza()
    {
        return $this->baza;
    }

    protected function setBaza($baza)
    {
        $this->baza = $baza;
    }
    //endregion

    /*protected function dohvatiSveSuper($upit) // ne odgovara pri ispisu svih redova, ukoliko postoji samo 1
    {
        $rezultat = $this->baza->izvrsiSelect($upit);
        if($rezultat->rowCount() == 1)
        {
            return $rezultat->fetch();
        }
        else
        {
            return $rezultat->fetchAll();
        }
    }*/

    protected function dohvatiSveSuper($upit)
    {
        $rezultat = $this->baza->izvrsiSelect($upit);
        return $rezultat->fetchAll();
    }
}