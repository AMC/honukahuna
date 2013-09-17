<?

class HK {
  
  public static function getConfig() {
    
  }
  
  public static function getRedirects() {
    $result = file_get_contents("config/routes.json");
    $result = str_replace("\n", "", $result);
    return json_encode($result);
  }
  
  public static function getJSON($filename) {
    
  }
}

class Route implements JsonSerializable {

  private $path;
  private $path_array;
  
  private $base;
  private $method;
  
  private $params;
  
  private $default_class;
  private $class;
  private $controller;
  private $action;
  
  private $redirects;
  
  public function __construct() {   
    $this->setPath();
    $this->setBase();
    $this->setMethod();
    $this->setParams();
    $this->setClass();
    $this->setController();
    $this->setAction();
    $this->setRedirects();
  }

/****************************************************************************/
  
  public function getBase() {
    return $this->base;
  }
  
  public function getClass() {
    return $this->class;
  }
  
  public function getController() {
    return $this->controller;
  }
  
  public function getAction() {
    return $this->action;
  }
    
  public function getParams() {
    if (!empty($this->params))
      return $this->params;
    return array();
  }
  
  public function getParamsString() {
    $result = "";
    foreach ($this->params as $key => $value)
      $result = "{$key} : {$value}";
    return $result;
  }
  
/****************************************************************************/
  
  private function getDefaultClass() {
    if (is_null($this->default_class))
      $this->setDefaultClass();
    return $this->default_class;
  }

  /****************************************************************************/

  private function setPath() {
    if (isset($_SERVER['PATH_INFO']))
      $this->path = $_SERVER['PATH_INFO'];
    else
      $this->path = "";
    
    $this->path_array = explode('/', $this->path);
  }
  
  private function setBase() {
    $this->base = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  }
  
  private function setMethod() {
    $this->method = strtolower($_SERVER['REQUEST_METHOD']);
  }
  
  private function setParams() {
    if ($this->method == 'get' && isset($_SERVER['QUERY_STRING']))
      parse_str($_SERVER['QUERY_STRING'], $this->params);
    else
      parse_str(file_get_contents("php://input"), $this->params);
  }
  
  private function setDefaultClass() {
    // TODO: load from config file
    $this->default_class = "Pages";
  }
  
  private function setClass() {
    if (is_null($this->default_class))
      $this->setDefaultClass();
    
    if (is_null($this->redirects))
      $this->setRedirects();
    
    if (isset($this->path_array[1])) 
      $this->class = ucwords($this->path_array[1]);
    else 
      $this->class = $this->getDefaultClass();
    
    // TODO: apply redirects
  }
  
  private function setController() {
    if (is_null($this->class))
      $this->setClass();
      
    $this->controller = $this->class . "Controller";
  }
  
  private function setAction() {
    if (is_null($this->path_array))
      $this->setPath();
    
    if (is_null($this->method))
      $this->setMethod();
    
    if (isset($this->path_array[2]))
      $this->action = $this->method . ucwords($this->path_array[2]);
    else
      $this->action = $this->method;
  }
  
  private function setRedirects() {
    // TODO: load from routes file
    // TODO: loadConfig($file) function
    // TODO: REDIRECTS!
    echo HK::getRedirects();
    $this->redirects = array();
  }

  
/****************************************************************************/

  
  public function __toString() {
    return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  }
  
  public function jsonSerialize() {
    return (object) get_object_vars($this);
  }
  
  
  
  
  
  
}

echo "<pre>";
$r = new Route();
echo $r;


