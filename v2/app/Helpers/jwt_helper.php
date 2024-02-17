<?php

use App\Libraries\Tokens;

function getData()
{

    $data = json_decode(seed('students'));
    $options = '';
    for ($i = 0; $i < count((array) $data); $i++)
        $options .= '<option id="' . $data[$i]->id . '"value="' . $data[$i]->firstName . ' ' . $data[$i]->lastName . '"></option>';
    echo '<datalist id="students">' . $options . '</datalist>';

    $data = json_decode(seed('subjects'));
    $options = '';
    for ($i = 0; $i < count((array) $data); $i++)
        $options .= '<option id="' . $data[$i]->id . '"value="' . $data[$i]->arabic . '"></option>';
    echo '<datalist id="subjects">' . $options . '</datalist>';

    $data = json_decode(seed('classes'));
    $options = '';
    for ($i = 0; $i < count((array) $data); $i++)
        $options .= '<option id="' . $data[$i]->name . '"value="' . $data[$i]->arabic . '"></option>';
    echo '<datalist id="classes">' . $options . '</datalist>';
}

function seed($specs)
{
    $token = new Tokens();
    $jwt = $token->getToken();

    $url = base_url('get/' . $specs, env('protocol')) . '?JWT=' . $jwt . '&class=' . session()->get('class') . '&ssms=true';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
