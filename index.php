<?php

require 'inc/class-Render.php';
$render = new Render();


$json_file = file_get_contents('patient.json');
$json = json_decode($json_file, true);
$json_data = $json['data'];


// doctor 
$doctor = $json_data['doctor'];
$doctor_name = $doctor['middle_name'] . ' ' . $doctor['first_name'] . ' ' . $doctor['last_name'];


// patient 
$patient = $json_data['patient'];
$patient_name = $patient['middle_name'] . ' ' . $patient['first_name'] . ' ' . $patient['last_name'];


// patient gender
$gender = 'male';
if ($patient['gender'] = 1) {
    $gender = 'female';
}


// metabolism
$metabolism = false;
if (array_key_exists('meta', $patient)) {
    $metabolism = $patient['meta'];
}


// diary
$diary = false;
if (array_key_exists('diary', $json_data)) {
    $diary = $json_data['diary'];
}


// ration, shopping list and recepies
$ration = false;
$shoppingList = false;
$rationOnWeeks = false;
$recipeOnWeeks = false;
if (array_key_exists('ration', $json_data)) {
    $ration = $json_data['ration'];

    if (array_key_exists('rationOnWeeks', $ration)) {
        $rationOnWeeks = $ration['rationOnWeeks'];
    }
    if (array_key_exists('shoppingList', $ration)) {
        $shoppingList = $ration['shoppingList'];
    }
    if (array_key_exists('recipeOnWeeks', $ration)) {
        $recipeOnWeeks = $ration['recipeOnWeeks'];
    }
}


// analisys
$analisys = false;


// hide sections
// $show_section = false;




$array_chunk = [];
$list = $shoppingList[0];
$length_str = 0;

$sorted_arr = [];
foreach ($list as $key => $li) {
    $length = strlen(json_encode($li));

    $length_str += $length;
    $sorted_arr[$key] = $li;

    // echo "$key  - $length  - $length_str <br>";

    if ($length_str >= 5000) {
        $last = end($sorted_arr);
        array_pop($sorted_arr);

        $array_chunk[] = $sorted_arr;

        $length_str = strlen(json_encode($last));
        $sorted_arr = [];
        $sorted_arr[$key] =  $last;
    }
}

$array_chunk[] = $sorted_arr;

// $render->pre($array_chunk);

foreach ($array_chunk as $list_items) :
endforeach;



// start building html
// ob_start();
require 'template-parts/head.php';

// web page 
require 'page-web.php';

// pdf page
require 'page-pdf.php';

require 'template-parts/scripts.php';

// $newcontent = ob_get_contents();
// ob_clean();

// $handle = fopen($patient_name . '.html', 'w+');
// $file = fwrite($handle, $newcontent);
// fclose($handle);


// $filename = $patient_name . '.html';

// if (file_exists($filename)) {
//     echo '<p>Отчет пациента <a href="/' . $filename . '">' . $filename . '</a> создан. <a href="/' . $filename . '">Посмотреть </a></p>';
// } else {
//     echo 'Произошла ошибка';
// }
