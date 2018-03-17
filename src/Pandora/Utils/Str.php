<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/05/2017
 * Time: 07:23
 */

namespace Pandora\Utils;


class Str
{
    /**
     * @param        $string
     * @param string $slug
     *
     * @return mixed|string
     */
    public function flag($string, $slug = '_')
    {
        $string = strtolower(utf8_decode($string));
        
        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['A'] = range(192, 197);
        $ascii['e'] = range(232, 235);
        $ascii['E'] = range(200, 203);
        $ascii['i'] = range(236, 239);
        $ascii['I'] = range(204, 207);
        $ascii['o'] = array_merge(range(242, 246), [
            240,
            248
        ]);
        $ascii['O'] = range(210, 214);
        $ascii['u'] = range(249, 252);
        $ascii['U'] = range(217, 220);
        
        // Código ASCII dos outros caracteres
        $ascii['b'] = [223];
        $ascii['c'] = [231];
        $ascii['C'] = [199];
        $ascii['d'] = [208];
        $ascii['n'] = [241];
        $ascii['y'] = [
            253,
            255
        ];
        
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo) {
                $acentos .= chr($codigo);
            }
            $troca[$key] = '/[' . $acentos . ']/i';
        }
        
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
        $string = strtolower($string);
        
        return $string;
    }
    
    function generatePassword($length, $capitalLetters = true, $numbers = true, $symbols = false)
    {
        // Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num  = '1234567890';
        $simb = '!@#$%*-';
        
        // Variáveis internas
        $ret        = '';
        $caracteres = '';
        
        // Agrupamos todos os caracteres que poderão ser utilizados
        $caracteres .= $lmin;
        
        $caracteres .= $capitalLetters ? $lmai : '';
        $caracteres .= $numbers ? $num : '';
        $caracteres .= $symbols ? $simb : '';
        
        // Calculamos o total de caracteres possíveis
        $len = strlen($caracteres);
        
        for ($n = 1; $n <= $length; $n++) {
            // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
            
            // Concatenamos um dos caracteres na variável $ret
            $ret .= $caracteres[$rand - 1];
        }
        
        return $ret;
    }
    
}