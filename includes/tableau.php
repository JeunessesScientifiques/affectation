<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tableau
 *
 * @author laurent
 */
class Tableau {

    private $lignes = Array();
    private $colones = Array();

    public function addLigne($ligne) {
        if ($this->colones == null) {
            $this->lignes[] = new Ligne($ligne);
        } else {
            $this->lignes[] = new Ligne($ligne);
            $this->createColone();
        }
    }

    private function createColone() {
        $taille = sizeof($this->lignes);
        for ($i = 0; $i < $taille; $i++) {
            $newColunm = Array();
            for ($j = 0; $j < $taille; $j++) {
                $newColunm[] = $this->lignes[$j]->getElement($i);
            }
            $this->colones[] = new Ligne($newColunm);
        }
    }

    public function reduction() {
        if ($this->colones == null) {
            $this->createColone();
        }
        foreach ($this->lignes as $ligne) {
            $ligne->reduction();
        }
        foreach ($this->colones as $colone) {
            $colone->reduction();
        }
    }

    public function __toString() {
        $retour = "<table>";
        foreach ($this->lignes as $ligne) {
            $retour .= "<tr>";
            foreach ($ligne->getTab() as $element) {
                $retour .= "<td>$element</td>";
            }
            $retour .= "</tr>";
        }
        $retour .= "</table>";

        return $retour;
    }

    public function getHTML() {
        $retour = "<table>";
        foreach ($this->lignes as $ligne) {
            $retour .= "<tr>";
            foreach ($ligne->getTab() as $element) {
                $retour .= "<td>" . $element->getHTML() . "</td>";
            }
            $retour .= "</tr>";
        }
        $retour .= "</table>";

        return $retour;
    }

    private function lessZero($lignes) {
        $meilleurLigne = NULL;
        $nb = 0;
        foreach ($lignes as $i => $ligne) {
            $nbtemp = $ligne->getNbZeroNonBarres();
            if (($nb == 0 || $nb > $nbtemp) && $nbtemp != 0) {
                $meilleurLigne = $i;
                $nb = $nbtemp;
            }
        }
        if ($nb > 0) {
            $ligneSelectionnee = $this->lignes[$meilleurLigne];
            $colone = $ligneSelectionnee->barreZeroSaufPremier();
            $this->colones[$colone]->barreZeroSauf($meilleurLigne);
            return $meilleurLigne + 1;
        } else {
            return false;
        }
    }

    public function etape2() {
        $lignes = $this->lignes;
        while ($this->lessZero($lignes) != false) {
            
        }
    }

    public function modificationTab() {
        $ligneMarque = Array();
        $coloneMarque = Array();

        //Initialisation - On marque les lignes sans zéros encadrés
        foreach ($this->lignes as $i => $ligne) {
            if (!$ligne->hasZeroEncadre()) {
                $ligneMarque[] = $i;
                echo "Je marque la ligne : " . ($i + 1) . "<br \>";
            }
        }

        $trouve = false;
        do {
            $trouve = false;

            //On marque les colonnes ayant un zéro barré dans une des lignes repérées plus haut
            foreach ($ligneMarque as $index) {
                foreach ($this->colones as $i => $colone) {
                    if ($colone->getElement($index)->isZeroBarre() && !$colone->isMarque()) {
                        $coloneMarque[] = $i;
                        $colone->marque();
                        $trouve = true;
                        echo "Je marque la colonne : " . ($i + 1) . "<br \>";
                    }
                }
            }

            //On marque les lignes ayant un zéro encadre dans une colone marqué
            foreach ($coloneMarque as $index) {
                foreach ($this->lignes as $i => $ligne) {
                    if ($ligne->getElement($index)->isZeroEncadre() && !$ligne->isMarque()) {
                        $ligneMarque[] = $i;
                        $ligne->marque();
                        echo "Je marque la ligne : " . ($i + 1) . "<br \>";
                        $trouve = true;
                    }
                }
            }
        } while ($trouve);
        //On va maintenant tirer un trait sur toutes les lignes non marquées
        foreach ($this->lignes as $i => $ligne) {
            if (array_search($i, $ligneMarque) === false) {
                $ligne->traitH();
                echo "Je barre la ligne : " . ($i + 1) . "<br \>";
            }
        }

        //On tire un trait sur toutes les colonnes marquées
        foreach ($coloneMarque as $index) {
            $this->colones[$index]->traitV();
            echo "Je barre la colonne : " . ($index + 1) . "<br \>";
        }

        //On classe les élements -> Tableau partiel ou double trait
        $tableauPartiel = Array();
        $doubleTrait = Array();

        foreach ($this->lignes as $ligne) {
            $double = $ligne->getDoubleTrait();
            $nonTrait = $ligne->getNonTrait();
            if ($double != null) {
                foreach ($double as $element) {
                    $doubleTrait[] = $element;
                }
            }
            if ($nonTrait != null) {
                foreach ($nonTrait as $element) {
                    $tableauPartiel[] = $element;
                }
            }
        }

        //Recherche du plus petit élement du tableau partiel.
        $ligneTemp = new Ligne($tableauPartiel);
        $minTabPartiel = min($ligneTemp->getIntTab());
        
        //On retire 4 à tous les élements du tableau partiel
        foreach ($tableauPartiel as $element){
            $element->retranche(intval($minTabPartiel));
        }
        
        //On ajoute 4 aux élements en croix
        foreach($doubleTrait as $element){
            $element->add($minTabPartiel);
        }
    }
    
    public function isOptimun(){
        $nb = sizeof($this->lignes);
        $i = 0;
        foreach ($this->lignes as $ligne) {
            if($ligne->hasZeroEncadre()){
                $i ++;
            }
        }
        
        return $i == $nb;
    }
    
    public function reset(){
        foreach($this->lignes as $ligne){
            $ligne->reset();
    }
    }

}
