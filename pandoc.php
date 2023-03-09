<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use Grav\Common\Utils;

class PandocPlugin extends Plugin
{
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }
    
    // Also see https://learn.getgrav.org/17/plugins/event-hooks#page-event-hooks
    public function onPageContentRaw(Event $event)
    {
        $page = $event['page'];
        
        // shouldProcess?
        $header = (array) $page->header();
        if (isset($header['process'])) {
            $process = (array) $header['process'];
            if (isset($process['markdown'])) {
                //if ( $page->value('header.process.markdown') == false ) return;
                if ( $process['markdown'] == false ) return;
            }
        }
        
        $content = $page->getRawContent();

        // preserving Twig: encode
        // taken from: system/src/Grav/Common/Page/Page.php
        $token = [
            '/' . Utils::generateRandomString(3),
            Utils::generateRandomString(3) . '/'
        ];
        // Base64 encode any twig.
        $content = preg_replace_callback(
            ['/({#.*?#})/mu', '/({{.*?}})/mu', '/({%.*?%})/mu'],
            static function ($matches) use ($token) { return $token[0] . base64_encode($matches[1]) . $token[1]; },
            $content
        );
        
        // here the pandoc magic happens :-)
        $output=null;
        $retval=null;
        setlocale(LC_CTYPE, "en_US.UTF-8"); // prevent escapeshellarg to strip non-ascii chars
        $escaped = escapeshellarg($content);
        $config = $this->mergeConfig($page, TRUE);
        $external = $config->get('command');
        if ( $external == "") $external = "pandoc"; // default value
        $cmd = "echo $escaped | $external 2>&1";
        exec($cmd, $output, $retval);
        if ($retval>0) {
            echo "pandoc plugin: error detected (return value greater than zero)";
            return;
        }
        $content = implode("\n",$output);
        
        // preserving Twig: decode
        // taken from: system/src/Grav/Common/Page/Page.php
        // Base64 decode the encoded twig.
        $content = preg_replace_callback(
            ['`' . $token[0] . '([A-Za-z0-9+/]+={0,2})' . $token[1] . '`mu'],
            static function ($matches) { return base64_decode($matches[1]); },
            $content
        );
        
        $page->setRawContent($content);
    }
}
