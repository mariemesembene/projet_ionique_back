<?php

namespace App\services;

 class ComptesService
{
    public function GenerateCompte($idTrans)
    {
        $code ='';
        for ($i=1;$i<=3;$i++)
        {
            $code= $code.''.$this->RandomNumber();
            if ($i<3)
            {
                $code.='-';
            }
            
        }
        $code[0]=$idTrans;
        return $code;
    }

    public function RandomNumber()
    {
        return rand(100,999);
    }


    }
