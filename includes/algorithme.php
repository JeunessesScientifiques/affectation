<?php

/*
 * Implémentation de l'alogorithme du Hongrois
 * 
 */

function methodeKuhn(Tableau $tab) {

// Etape 1, trouver le minimun de chaque ligne et soustraire celui-ci à tous les élements de la ligne
    $tab->reduction();

    echo "Tableau après réduction : <br /><br />" . $tab->getHtml() . " <br />";
  
    do {
        $tab->etape2();

        echo "Tableau après l'étape 2: <br /><br />" . $tab->getHtml() . " <br />";
        
        

        if (!$tab->isOptimun()) {
            
            $tab->modificationTab();
            $tab->reset();

            echo "<br />Tableau après l'étape 3 : <br /><br />" . $tab->getHTML() . " <br />";
        }else{
            break;
        }
    } while (true);
}
