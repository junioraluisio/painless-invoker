<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 29/04/2017
 * Time: 13:51
 */

namespace Pandora\Debug;


class Debug
{
    /**
     * @param $var
     *
     * @return string
     */
    static public function debug($var)
    {
        $backTrace = debug_backtrace();
        
        $typeVar = gettype($var);
        
        $debug = self::debugCss();
        
        $debug .= self::debugHead($backTrace, $typeVar);
        
        $debug .= self::debugVar($var);
        
        $debug .= self::debugFoot();
        
        return $debug;
    }
    
    /**
     * @param $str
     *
     * @return mixed
     */
    static private function debugColor($str)
    {
        $str = preg_replace("/\[(\w*)\]/i", '[<span style="color: #c0392b">$1</span>]', $str);
        $str = preg_replace("/(\s+)\)$/", '$1)</span>', $str);
        $str = str_replace('Array', '<span style="color: blue">Array</span>', $str);
        $str = str_replace('=>', '<span style="color: #556F55">=></span>', $str);
        
        return $str;
    }
    
    /**
     * @param $backTrace
     * @param $typeVar
     *
     * @return string
     */
    static function debugHead($backTrace, $typeVar)
    {
        return '<div class="msgDebug">
          <h6>DEBUG</h6>
          <p>
            <span class="tip2">#Arquivo:</span> ' . $backTrace[0]['file'] . '<br />
            <span class="tip2">#Linha:</span> ' . $backTrace[0]['line'] . '<br />
            <span class="tip2">#Tipo da variável:</span> ' . $typeVar . '<br />
          </p>
          <br />
          <pre>';
    }
    
    /**
     * @return string
     */
    static private function debugCss()
    {
        $css = '<style type="text/css">';
        $css .= file_get_contents(dirname(__DIR__,3) . '/assets/css/debug.css');
        $css .= '</style>';
        
        return $css;
    }
    
    /**
     * @return string
     */
    static private function debugFoot()
    {
        return '</pre>
          <div class="clear"></div>
          </div>';
    }
    
    /**
     * @param $var
     *
     * @return mixed
     */
    static private function debugVar($var)
    {
        if (is_scalar($var)) {
            $txt = preg_replace('/\s\s+/', ' ', $var);
            
            $arrSQL_A = [
                "/INSERT/",
                "/UPDATE/",
                "/SELECT/",
                "/FROM/",
                "/INTO/",
                "/SET\s/",
                "/VALUES/",
                "/WHERE/",
                "/AND\s/",
                "/ORDER BY/",
                "/OR\s/",
                "/LIMIT/",
                "/IN\s/",
                "/LIKE/",
                "/ASC\s/"
            ];
            
            $arrSQL_B = [
                "<strong>INSERT</strong>",
                "<strong>UPDATE</strong>",
                "<strong>SELECT</strong>",
                "\n<strong>FROM</strong>",
                "<strong>INTO</strong>",
                "\n<strong>SET </strong>",
                "\n<strong>VALUES</strong>",
                "\n<strong>WHERE</strong>",
                "\n<strong>AND </strong>",
                "<strong>ORDER BY</strong>",
                "\n<strong>OR </strong>",
                "\n<strong>LIMIT</strong>",
                "<strong>IN </strong>",
                "<strong>LIKE</strong>",
                "<strong>ASC </strong>"
            ];
            
            return preg_replace($arrSQL_A, $arrSQL_B, $txt);
        } else {
            $text = serialize($var);
            $text = unserialize($text);
            $text = print_r($text, true);
            
            $arr_A = [
                '/Array/',
                '/\[/',
                '/\]/',
                '@<script[^>]*?>.*?</script>@si',
                '@<[\/\!]*?[^<>]*?>@si',
                '@<style[^>]*?>.*?</style>@siU',
                '@<![\s\S]*?--[ \t\n\r]*>@'
            ];
            
            $arr_B = [
                '<strong>Array</strong>',
                '[<span class=\"tip0\">',
                '</span>]',
                '',
                '',
                '',
                ''
            ];
            
            $text = preg_replace($arr_A, $arr_B, $text);
            
            return self::debugColor($text);
        }
    }
    
    /**
     * @return string
     */
    static public function debugInterrupt()
    {
        $backTrace = debug_backtrace();
        
        $css = '<style type="text/css">';
        $css .= file_get_contents(dirname(__DIR__,3) .  '/assets/css/debug_interrupt.css');
        $css .= '</style>';
        
        $css .= '<div class="msgDebug">
          <h6>Interrupção</h6>
          <p>
            <span class="tip2">#Arquivo:</span> ' . $backTrace[0]['file'] . '<br />
            <span class="tip2">#Linha:</span> ' . $backTrace[0]['line'] . '</p>
          <br />
          <pre>
          </pre>
          <div class="clear"></div>
          </div>';
        
        return $css;
    }
}