<?php
namespace App\DTO;

class ProfilDTO
{
    public String $username;
    public String $password;
    public String $newPassword;
    public String $Confirm;

    public function getUsername()
    {
        return $this->username;
    } 

    public function setUsername($username){
        $this->username = $username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;   
    }

    public function getNewPassword(){
        return $this->newPassword;
    }

    public function setNewPassword($newPassword){
        $this->newPassword = $newPassword;
    }

    public function getConfirm(){
        return $this->Confirm;
    }

    public function setConfirm($confirmer){
        $this->Confirm = $confirmer;
    }


}