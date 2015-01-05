<htlm>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="includes/style.css" />
    </head>
    <body>
<?php

//Inclusion des fichiers

foreach(glob('includes/*.php') as $include){
    include($include);
}

$tab = new Tableau();

$tab->addLigne(array(3,4,5,4,6));
$tab->addLigne(array(4,5,2,3,6));
$tab->addLigne(array(5,1,6,5,1));
$tab->addLigne(array(6,7,7,10,8));
$tab->addLigne(array(4,5,3,5,6));

echo "Tableau initial : <br \><br \> $tab <br \>";

methodeKuhn($tab);



?>
    </body>
</htlm>