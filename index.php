<?
  $default_class      = 'HK';
  $default_controller = 'HKController';

  $base   = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  $method = strtolower($_SERVER['REQUEST_METHOD']);

  if (isset($_SERVER['PATH_INFO']))
    $path = explode('/', $_SERVER['PATH_INFO']);
  else 
    $path = array();

  if (isset($path[1]))
    $class = ucwords($path[1]);
  else
    $class = $default_class;

  $classFile = fileExists($class, "{$class}.php");
  if ($classFile)
    require_once $classFile['path'];
  else
    die("file not found: classes/{$class}/{$class}.php");

  $controller = fileExists($class, "{$class}Controller.php");
  if ($controller)
    require_once $controller['path'];
  else
    die("controller not found: classes/{$class}/{$controller}");

  if (isset($path[2]))
    $action = $method . ucwords($path[2]);
  else
    $action = $method;


  if ($_SERVER['REQUEST_METHOD'] == 'GET')
    parse_str($_SERVER['QUERY_STRING'], $params);
  else 
    parse_str(file_get_contents("php://input"), $params);

  $c = new $controller['filename']();
  $c->$action();

  
  function fileExists($class, $file) {
    $folder = "classes/{$class}";
    $fileArray = glob("{$folder}/*", GLOB_NOSORT);
    foreach($fileArray as $f) 
      if (strtolower($f) == strtolower("{$folder}/{$file}"))
        return array_merge(pathinfo($f), array('path' => $f));
    
    return false;
  }
  
?>

<h3>Index</h3>
  <a href='<?= $base ?>'>HK</a> 
  <a href='<?= "{$base}hello/world?A=1&B=2" ?>'>link</a> 

<pre>
  $base   = <?= $base ?> 
  $method = <?= $method ?> 
  $path   = <? print_r($path) ?> 

  $class      = <?= $class ?> 
  $controller = <?= $controller ?> 
  $action     = <?= $action ?> 

  $params     = <? print_r($params) ?>

</pre>


<?
/*
  $controller = $_SERVER['']
  $action
  $params




/*
require_once 'classes/HK/HK.php';

spl_autoload_register('HK::autoloader');

$hk_base  = HK::getBase();
$hk_route = HK::getRoute();

session_start();

// HK::log('temp', $_SERVER['REQUEST_METHOD']);



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
*/
    ?>