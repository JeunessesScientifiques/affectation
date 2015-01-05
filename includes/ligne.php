<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ligne
 *
 * @author laurent
 */
class Ligne {
    private $ligne=Array();
    private $marque = false;
    
    public function __construct(Array $tab) {
        foreach($tab as $element){
            if($element instanceof Element){
                $this->addElement($element);
            }else{
                $this->addElement(new Element($element));
            }
        }
    }
    
    public function addElement(Element $element){
        $this->ligne[] = $element;
    }
    
    public function getElement($index){
        return $this->ligne[$index];
    }
    
    public function __toString() {
        $retour = "";
        foreach($this->ligne as $element){
            $retour .= " $element";
        }
        return $retour;
    }
    
    public function reduction(){
        $min = min($this->getIntTab());
        $this->nbZeroNonBarres = 0;
        foreach($this->ligne as $element){
            $element->retranche($min);
            if($element->isZeroNonBarre()){
                $this->nbZeroNonBarres ++;
            }
        }
    }
    
    public function getIntTab(){
        $tab = Array();
        foreach ($this->ligne as $val){
            $tab[] = $val->getInt();
        }
        return $tab;
    }
    
    public function getTab(){
        return $this->ligne;
    }
    
    public function getNbZeroNonBarres(){
        $i = 0;
        foreach ($this->ligne as $element){
            if($element->isZeroNonBarre() && !$element->isEncadre()){
                $i++;
            }
        }
        return $i;
    }
    
    public function barreZeroSauf($numLigne){
        foreach($this->ligne as $i => $element){
            if($element->isZeroNonBarre()){
                if($i!=$numLigne){
                    $element->barre();
                }
            }
        }
    }
    
    public function barreZeroSaufPremier(){
        $trouve = false;
        foreach($this->ligne as $i => $element){
            if($element->isZeroNonBarre()){
                if(!$trouve){
                    $element->encadre();
                    $retour=$i;
                    $trouve = true;
                }else{
                    $element->barre();
                }
            }
        }
        if(!isset($retour)){
            $retour = false;
        }
        return $retour;
    }
    
    public function getZeroBarre(){
        $retour = Array();
        foreach ($this->ligne as $i =>$element){
            if($element->isZeroBarre()){
                $retour[]=$i;
            }
        }
        if($retour==null){
            return false;
        }else{
            return $retour;
        }
    }
    
    public function hasZeroEncadre(){
        $retour = false;
        foreach($this->ligne as $element){
            if($element->isZeroEncadre()){
                $retour = true;
            }
        }
        return $retour;
    }
    
    public function isMarque(){
        return $this->marque;
    }
    
    public function marque(){
        $this->marque = true;
    }
    
    public function traitH(){
        foreach($this->ligne as $element){
            $element->setTraitH(true);
        }
    }
    
    public function traitV(){
        foreach($this->ligne as $element){
            $element->setTraitV(true);
        }
    }
    
    public function getDoubleTrait(){
        $retour = Array();
        foreach($this->ligne as $element){
            if($element->isDoubleTrait()){
                $retour[] = $element;
            }
        }
        return $retour;
    }
    
    public function getNonTrait(){
        $retour = Array();
        foreach($this->ligne as $element){
            if($element->isNonTrait()){
                $retour[] = $element;
            }
        }
        return $retour;
    }
    
    public function reset(){
        foreach($this->ligne as $element){
            $element->reset();
        }
    }
        
    }
    
