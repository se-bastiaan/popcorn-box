<?php

	class Routing {

		public static function init() {
			$segment = $_SERVER["REQUEST_URI"];
			if( strstr($segment, "?") )
				$segment = substr($segment, 0, strpos($segment, "?"));
			$segment = explode("/", str_replace("//", "/", $segment));
			unset($segment[0]);
            $segment  = array_values($segment);

			$request_method = $_SERVER["REQUEST_METHOD"];
			if(empty($segment[0])) {				
				self::redirect(Config::get('routing', 'base_controller'));
			} else {
				$controller = $segment[0];
                if(Config::get('routing', $controller)) {
                    $controller = Config::get('routing', $controller);
                }
				$controller = ucfirst($controller);
				$controller = $controller . '_Controller';
                $opened_controller = null;
                if(class_exists($controller)) {
    				$opened_controller = new $controller();
                    if(is_subclass_of($opened_controller, 'Controller')) {
        				$method = strtolower($request_method) . '_';
        				if(!isset($segment[1]) || empty($segment[1])) {
        					$method = $method . 'index';
        				} else {
        					$method = $method . $segment[1];
        				}
                        if(method_exists($opened_controller, $method)) {
                            $opened_controller->$method();
                        } else {
                            $opened_controller->_404($method);
                        }
                        $opened_controller->do_output();
                    } else {
                        self::redirect(Config::get('routing', '404_controller'));
                    }
                } else {
                    self::redirect(Config::get('routing', '404_controller'));
                }
			}
		}

		public static function get_segment($index = false) {
			$segment = $_SERVER["REQUEST_URI"];
			if( strstr($segment, "?") )
				$segment = substr($segment, 0, strpos($segment, "?"));
			$segment = explode("/", str_replace("//", "/", $segment));
            unset($segment[0]);
            $segment  = array_values($segment);
            if(!$index && !is_numeric($index)) {
	            $return = "";
	            foreach($segment as $k => $s) {
		            $return .= $s;
		            if(count($segment) - 1 !== $k) $return .= "/";
	            }
	            return $return;
            } elseif(isset($segment[$index])) {
	            return $segment[$index];
            }
			return false;
		}

		public static function base_url($string = '') {
		    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		    return $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace("index.php", "", $_SERVER['PHP_SELF']) . $string;
		}

		public static function base_uri($string = '') {
		    return str_replace("index.php", "", $_SERVER['PHP_SELF']) . $string;
		}

        public static function root_dir($string = '') {
            return str_replace("inc/core", "", __DIR__) . $string . "/";
        }

		public static function redirect($uri) { 
    		if(!strpos($uri, "http") === 0) {
    			$uri = self::base_url($uri);
    		} else {
                $uri = self::base_uri($uri);
            }
		    header('Location: '.$uri);
		}

		public static function anchor($uri, $text, $class = null) {
			if(!strpos($uri, "http")) {
				$uri = self::base_url($uri);
			}
			
			if($class == null) {
				$class = '';
			} else {
				$class = ' class="' . $class . '"';
			}
			
			
			return '<a href="' . $uri . '"' . $class . '>' . $text .  '</a>';
		}

		public static $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );

        public static function get_ip() {
            $ip = $_SERVER['REMOTE_ADDR'];      
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }        
            return $ip;
        }

        public static function get_useragent() {
            $useragents_array = array('HTTP_X_ORIGINAL_USER_AGENT','HTTP_X_DEVICE_USER_AGENT', 'HTTP_X_OPERAMINI_PHONE_UA','HTTP_X_BOLT_PHONE_UA', 'HTTP_X_MOBILE_UA', 'HTTP_USER_AGENT');
            foreach ($useragents_array as $ua) {
                if (!empty($_SERVER[$ua])) {
                    return $_SERVER[$ua]; //REAL UA
                    break;
                }
            }
        }

	}