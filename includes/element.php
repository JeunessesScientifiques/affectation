<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of element
 *
 * @author laurent
 */
class Element {
    private $val;
    private $barre=false;
    private $encadre=false;
    private $traitH=false;
    private $traitV=false;
    
    public function __construct($val) {
        $this->setVal($val);
    }
    
    public function setVal($val){
        $this->val = $val;
    }
    
    public function getVal(){
        return $this->val;
    }
    
    public function __toString() {
        return (string) $this->getVal();
    }
    
    public function retranche($val){
        $this->val -= $val;
        return $this->getVal();
    }
    
    public function getInt(){
        return intval($this->val);
    }
    
    public function isZeroBarre(){
        return intval($this->val)===0 && $this->barre;
    }
    
    public function isZeroEncadre(){
        return intval($this->val)===0 && $this->encadre;
    }
    
    public function isZeroNonBarre(){
        return intval($this->val)===0 && !$this->barre;
    }
    

    public function encadre(){
        $this->encadre = true;
    }
    
    public function barre(){
        $this->barre = true;
    }
    
    public function getHTML(){
        if($this->encadre){
            $retour = "[".$this->getVal()."]";
        }elseif($this->barre){
            
            $retour = "X ". $this->getVal();
        }else{
            $retour = $this->getVal();
        }
        return $retour;
    }
    
    public function isEncadre(){
        return $this->encadre;
    }
    
    public function setTraitH($val){
        $this->traitH = $val;
    }
    
    public function setTraitV($val){
        $this->traitV = $val;
    }
    
    public function isDoubleTrait(){
        return $this->traitH && $this->traitV;
    }
    
    public function isNonTrait(){
        return !$this->traitH && !$this->traitV;
    }
    
    public function add($val){
        $this->val += $val;
    }
    
    public function reset(){
        $this->barre = false;
        $this->encadre = false;
        $this->traitH = false;
        $this->traitV = false;
    }
    
}
