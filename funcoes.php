<?php

$rs_ano=date ("Y", mktime (0,0,0,date("m")-1,1,date("Y")));
$dia_inventario = date('d');

$mes_inventario = date ("n", mktime (0,0,0,date("m"),1,date("Y")));
#echo $mes_inventario;

//if (($dia_inventario ==31)  && ($mes_inventario ==8 or $mes_inventario ==3))
//{
$rs_mes=date ("n", mktime (0,0,0,date("m"),1,date("Y")));
//}
//else
//{
//$rs_mes=date ("n", mktime (0,0,0,date("m")-1,1,date("Y")));
//}



$rs_ano_pedido=date ("Y", mktime (0,0,0,date("m"),1,date("Y")));
$rs_mes_pedido=date ("n", mktime (0,0,0,date("m"),1,date("Y")));


if (!function_exists('mesbr_ext')) {

  function mesbr_ext($mes) {

    if ($mes == "1") { return "Jan"; }
    if ($mes == "2") { return "Fev"; }
    if ($mes == "3") { return "Mar"; }
    if ($mes == "4") { return "Abr"; }
    if ($mes == "5") { return "Mai"; }
    if ($mes == "6") { return "Jun"; }
    if ($mes == "7") { return "Jul"; }
    if ($mes == "8") { return "Ago"; }
    if ($mes == "9") { return "Set"; }
    if ($mes == "10") { return "Out"; }
    if ($mes == "11") { return "Nov"; }
    if ($mes == "12") { return "Dez"; }
  }

}

if (!function_exists('convert_date_from_format')) {

  function convert_date_from_format($value, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
  {
    if(empty($value)){
      return;
    }

    $date = DateTime::createFromFormat($fromFormat, $value);
    return $date->format($toFormat);
  }
}



if (!function_exists('formataData')) {

  function formataData($data) {
    $hora = substr($data,10,9);
    $data = substr($data,0,10);

    if (substr($data, 2, 1) == "/")
      return implode('-', array_reverse(explode('-', $data))).$hora;
    else
      return implode('-', array_reverse(explode('-', $data))).$hora;
  }
}


if (!function_exists('converte_data')) {

  function converte_data($data){
    if ($data == "") { return ""; }
    if (strstr($data, "/")){
      $a = explode ("/", $data);
      $v_data = $a[2] . "-". $a[1] . "-" . $a[0];
    }
    else
    {
      $a = explode ("-", $data);
      $a_data = $a[2] . "/". $a[1] . "/" . $a[0];
    }
    return $v_data;
  }
}

if (!function_exists('convert_date')) {

  function convert_date($value, $format = 'd/m/Y')
  {
    if(empty($value)){
      return null;
    }

    $date = new DateTime($value);
    return $date->format($format);
  }
}

if (!function_exists('convert_horasMinutos')) {

  function convert_horasMinutos($value, $format = 'H:i')
  {
    if(empty($value)){
      return null;
    }

    $date = new DateTime($value);
    return $date->format($format);
  }
}

if (!function_exists('format_dateAM')) {

  function format_dateAM($date, $format = 'Y-m-d'){
    if(empty($date))
      return false;

    $dateFormat = new DateTime($date);
    return $dateFormat->format($format);
  }

}

if (!function_exists('formatar')) {

  function formatar ($string, $tipo = "")
  {
    $string = ereg_replace("[^0-9]", "", $string);
    if (!$tipo)
    {
      switch (strlen($string))
      {
        case 10:    $tipo = 'fone';     break;
        case 8:     $tipo = 'cep';      break;
        case 11:    $tipo = 'cpf';      break;
        case 14:    $tipo = 'cnpj';     break;
      }
    }
    switch ($tipo)
    {
      case 'fone':
        $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
        break;
      case 'cep':
        $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
        break;
      case 'cpf':
        $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
        break;
      case 'cnpj':
        $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
        break;
      case 'rg':
        $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3);
        break;
    }
    return $string;
  }
}

if (!function_exists('verificaBrowser')) {

  function verificaBrowser()
  {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'IE';
    } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Opera';
    } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Firefox';
    } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Chrome';
    } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
      $browser_version=$matched[1];
      $browser = 'Safari';
    } else {
      // browser not recognized!
      $browser_version = 0;
      $browser= 'other';
    }

    return $browser;
  }
}

if (!function_exists('mask')) {

  function mask($value, $mask)
  {
    if(empty($value)){
      return false;
    }

    $k = 0;
    $maskared = '';

    for ($i = 0; $i < strlen($mask); $i++) {
      if (substr($mask, $i, 1) == '#') {
        $maskared .= substr($value, $k++, 1);
      } else {
        $maskared .= substr($mask, $i, 1);
      }
    }
    return $maskared;
  }
}

if (!function_exists('json_response')) {

  function mask_telefone($value)
  {
    $pattern = strlen($value) === 11 ? '(##) # ####-####' : '(##) ####-####';

    return mask($value, $pattern);
  }
}

if (!function_exists('json_response')) {

  function json_response(array $data, $code = 200)
  {
    header('Content-Type: application/json');
    http_response_code($code);
    return json_encode($data);
  }
}

?>
