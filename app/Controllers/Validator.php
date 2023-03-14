<?php

namespace App\Controllers;

class Validator extends Controller
{
public function validate($array): string
{
    $valide = "";
    foreach ($array as $fieldname => $conditions) {
        foreach ($conditions as $condition) {
            switch ($condition) {
                case 'required':
                    if (empty($_POST[$fieldname])) {
                        $valide = $valide . "Le champ " . $fieldname . " est obligatoire.";
                    }
                    break;

                case 'max50':
                    if (strlen($_POST[$fieldname]) > 50 && !empty($_POST[$fieldname])) {
                        $valide = $valide . "Le champ " . $fieldname . " doit contenir moins de 50 charactères.";
                    }
                    break;
            }
        }
    }
    return $valide;
}
}