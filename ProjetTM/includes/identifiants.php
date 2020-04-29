<?php
try
{
$db = new PDO('mysql:host=localhost;dbname=projettm', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>
