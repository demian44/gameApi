<?php
/*
 * Los usuarios pueden ser socios o empleados
 */
class User extends Foto
{
    private $email;
    private $pass;
    private $actualGame;
    private $actualGamePoints;
    public $naval;
    public $tateti;
    public $agilidad;
    public $piedra;
    public $numero;
    public $anagrama;

    public function __construct($email, $pass)
    {
        $this->email = $email;
        $this->pass = $pass;
    }

    /// Getters
    public function GetEmail()
    {
        return $this->email;
    }
    public function GetActualGame()
    {
        return $this->actualGame;
    }
    public function GetActualGamePoints()
    {
        return $this->actualGamePoints;
    }
    
    public function GetUser()
    {
        return $this->user;
    }

    public function GetPass()
    {
        return $this->pass;
    }
    // End Getters

    ///Setters
    public function SetEmail($email)
    {
        $retorno = false;
        if (is_string($email) && $email != '') {
            $this->email = $email;
            $retorno = true;
        }

        return $retorno;
    }
    public function SetActualGame($game)
    {
        $this->actualGame = $game;
    }
   
    public function SetActualGamePoints($game)
    {
        $this->actualGamePoints = $game;
    }
   
 

    public function SetPass($pass)
    {
        $retorno = false;
        if (is_string($pass) && $pass != '') {
            $this->pass = $pass;
            $retorno = true;
        }

        return $retorno;
    }

    public function SetUser($user)
    {
        $retorno = false;
        if (is_string($user) && $user != '') {
            $this->user = $user;
            $retorno = true;
        }

        return $retorno;
    }

}
