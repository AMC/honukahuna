<?

class HK {
  
  
  public static function autoloader($class) {
    if (file_exists("classes/$class/$class.php")) 
      require_once "classes/$class/$class.php";
    else if (file_exists("datatypes/$class.php"))
      require_once "datatypes/$class.php";
  }
  
  public static function getBase() {
    return str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
  }
  
  public static function getRoute() {
    if (!isset($_SERVER['PATH_INFO']))
      return;
      
    $route = explode('/', $_SERVER['PATH_INFO']);
    array_shift($route);
    return $route;      
  }
  
  public static function log($log, $content) {
    $fp = fopen('logs/' . $log . '.log', 'a');
    $content = json_encode($content);
    
    $content = HK::format_json($content);
    fwrite($fp, $content);
    fwrite($fp, PHP_EOL);
    fclose($fp);
  }
  
  public static function format_json($json) {
  	$indents=0;
  	$output='';
  	$inside=false;
  	for ($i = 0, $j = strlen($json); $i < $j; $i++) {
  		$char=$json[$i];
  		if($char=='{' || $char=='[') {
  			if(!$inside) {
  				$indents+=3;
  				$output.=$char."\n" . HK::space($indents);
  			}else{
  				$output.=$char;
  			}
  		}elseif($char==',') {
  			if(!$inside) {
  				$output.=$char."\n". HK::space($indents);
  			}else{
  				$output.=$char;
  			}
  		}elseif($char==':') {
  			if(!$inside) {
  				$output.=$char." ";
  			}else{
  				$output.=$char;
  			}
  		}elseif($char=='}' || $char==']') {
  			if(!$inside) {
  				$indents-=3;
  				$output.="\n".HK::space($indents).$char;
  			}else{
  				$output.=$char;
  			}
  		}elseif($char=='"') {
  			if($inside) {
  				$inside=false;
  			}else{
  				$inside=true;
  			}
  			$output.=$char;
  		}else{
  			$output.=$char;
  		}
  	}
  	$output=str_replace('\/','/',$output);
  	return $output;
  }
  /**
   * Returns a string containing a given number of spaces. Used by the format_json function.
   *
   * @param integer $x The number of spaces to return
   * @return string A given number of spaces.
   *
   * @author Edmund Gentle (https://github.com/edmundgentle)
   */
  
  public static function space($x) {
  	$output='';
  	for($y=1;$y<=$x;$y++) {
  		$output.=' ';
  	}
  	return $output;
  }
  
}