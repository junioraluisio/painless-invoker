<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 20/05/2017
 * Time: 15:41
 */
if (!function_exists('token_user')) {
    /**
     * @param string $type  tipo do campo de comparação
     * @param string $value campo de comparação
     *
     * @return string
     */
    function token_user(string $type, string $value)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $header = json_encode($header);
        $header = base64_encode($header);
        
        $payload = [
            'type'  => $type,
            'value' => $value
        ];
        $payload = json_encode($payload);
        $payload = base64_encode($payload);
        
        $data = $header . '.' . $payload;
        
        $key = $_ENV['JWT_SECRET'] ?? 'hu6ANecrAYed2FeBrUYaze34HaWa2ruzaZa6uxEzadREheWepeThEcremuxeJucewab22truteze4rA8ratheps8raSTaca5adruR36';
        
        $signature = hash_hmac('sha256', $data, $key, true);
        $signature = base64_encode($signature);
        
        return $data . '.' . $signature;
    }
}

if (!function_exists('password')) {
    /**
     * @param string $password senha base para geração do hash
     *
     * @return bool|string
     */
    function password(string $password)
    {
        $options = [
            'cost' => 13
        ];
        
        return password_hash($password, PASSWORD_DEFAULT, $options);
    }
}

if (!function_exists('flag')) {
    /**
     * @param string $str
     * @param string $slug
     *
     * @return string
     */
    function flag(string $str, string $slug = '_'): string
    {
        $flag = strtolower(utf8_decode($str));
        
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
        
        $swap = [];
        
        foreach ($ascii as $key => $item) {
            $accents = '';
            foreach ($item AS $code) {
                $accents .= chr($code);
            }
            $swap[$key] = '/[' . $accents . ']/i';
        }
        
        $flag = preg_replace(array_values($swap), array_keys($swap), $flag);
        
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $flag = preg_replace('/[^a-z0-9]/i', $slug, $flag);
        
        // Tira os caracteres ($slug) repetidos
        $flag = preg_replace('/' . $slug . '{2,}/i', $slug, $flag);
        $flag = trim($flag, $slug);
        $flag = strtolower($flag);
        
        return $flag;
    }
}

if (!function_exists('deKrypt')) {
    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     *
     * @param string $action : can be 'encrypt' or 'decrypt'
     * @param string $string : string to encrypt or decrypt
     *
     * @return string
     */
    function deKrypt($action, $string)
    {
        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key     = $_ENV['JWT_SECRET'];
        $secret_iv      = $_ENV['JWT_ID'];
        
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        
        return $output;
    }
}