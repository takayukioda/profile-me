<?php
/**
 * Auto class loader based on \Fuel\Core\Autoloader
 * @author da0shi
 * @version 1.0
 *
 */
class Autoloader
{
    /**
     * @var array $cores directory with core files
     */
    protected static $cores = array(
        'packages',
        'models',
    );

    /**
     * @var array $namespaces holds all the namespace paths.
     */
    protected static $namespaces = array();

    /**
     * @var array $classes holds all the classes and paths.
     */
    protected static $classes = array();

    /**
     * Adds a namespace search path.
     *
     * @param string $namespace the namespace
     * @param string $path the path
     * @return void
     */
    public static function addNamespace ($namespace, $path)
    {
        static::$namespaces[$namespace] = $path;
    }

    /**
     * Adds an array of namespace paths.
     *
     * @param array $namespaces the list of namespaces and paths
     * @return void
     */
    public static function addNamespaces (array $namespaces)
    {
        foreach ($namespaces as $namespace => $path) {
            static::addNamespace($namespace, $path);
        }
    }

    /**
     * Returns the namespace's path. Returns null if not exists.
     *
     * @param string $namespace the namespace
     * @return array|null the namespace path | null
     */
    public static function namespacePath ($namespace)
    {
        if (! array_key_exists($namespace, static::$namespaces)) return false;

        return static::$namespaces[$namespace];
    }

    /**
     * Adds a class to load Path.
     *
     * @param string $class the class name
     * @param string $path the path to the class file
     * @return void
     */
    public static function addClass ($class, $path)
    {
        static::$classes[$class] = $path;
    }

    /**
     * Adds multiple class paths to the load path.
     *
     * @param array $classes the classes and paths
     * @return void
     */
    public static function addClasses ($classes)
    {
        foreach ($classes as $class => $path) {
            static::addClass($class, $path);
        }
    }

    /**
     * Register's the Autoloader to the spl autoload stack
     *
     * @return void
     */
    public static function register ()
    {
        spl_autoload_register('Autoloader::load', true, true);
    }

    /**
     * Load a class
     *
     * @param string $class class to load
     * @return bool whether it is loaded or not
     */
    public static function load ($class)
    {
        // do not try to load Autoloader itself which is already loaded.
        if (strpos($class, 'static::') === 0) return true;

        $loaded = false;
        $class = ltrim($class, '\\');
        $pos = strripos($class, '\\');
        $namespaced = ($pos !== false);

        if (isset(static::$classes[$class])) {
            static::initClass(
                $class, str_replace('/', DS, static::$classes[$class]));
            $loaded = true;
        } else {
            $fullNs = substr($class, 0, $pos);

            if ($fullNs) {
                foreach (static::$namespaces as $ns => $path) {
                    $ns = ltrim($ns, '\\');
                    if (stripos($fullNs, $ns) === 0) {
                        $path .= static::classToPath(
                            substr($class, strlen($ns) + 1));
                        if (is_file($path)) {
                            static::initClass($class, $path);
                            $loaded = true;
                            break;
                        }
                    }
                }
            }

            if (! $loaded) {
                foreach (static::$cores as $core) {
                    $path = APPPATH . $core .DS. static::class_to_path($class);
                    if (is_file($path)) {
                        static::initClass($class, $path);
                        $loaded = true;
                        break;
                    }
                }
            }
        }

        return $loaded;
    }

    /**
     *
     *
     * @param string $class class name
     * @return string path for the class
     */
    protected static function class_to_path ($class)
    {
        $file = '';
        $lastNsPos = strripos($class, '\\');
        if ($lastNsPos) {
            $namespace = substr($class, 0, $lastNsPos);
            $class = substr($class, $lastNsPos);
            $file = str_replace('\\', DS, $namespace) .DS;
        }
        $file .= str_replace('_', DS, $class) .'.php';
        return strtolower($file);
    }

    /**
     * Check
     *
     */
    protected static function initClass ($class, $file = null)
    {
        if ($file) {
            include_once($file);
        }

        if (class_exists($class, false)) {
            // just check whether it exists
        } else if (interface_exists($class, false)) {
            // just check whether it exists
        } else if (function_exists('triat_exists') &&
            triat_exists($class, false)) {
            // just check whether it exists
        } else if ($file) {
            throw new \Exception(
                'File "'. $file .'" does not contain class "'. $class .'"');
        } else {
            throw new \Exception('Class "'. $class .'" is not defined');
        }
    }
}
