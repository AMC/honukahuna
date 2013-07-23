<?
require_once 'classes/HK/HK.php';

spl_autoload_register('HK::autoloader');

$hk_base  = HK::getBase();
$hk_route = HK::getRoute();

session_start();

// HK::log('temp', $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] == 'GET')
  parse_str($_SERVER['QUERY_STRING'], $variables);
else 
  parse_str(file_get_contents("php://input"), $variables);

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':  
    
    break;
    
  case 'POST':
    
    break;
    
  case 'PUT':
    
    break;
  
  case 'DELETE':
    
    break;
}




?>
<pre>
<? echo $_SERVER['REQUEST_METHOD'] . PHP_EOL ?>
  
<? foreach ($variables as $key => $value) { ?>
<?= "{$key} : {$value}" . PHP_EOL ?>
<? } ?>
  
<? print_r($_SERVER) ?>