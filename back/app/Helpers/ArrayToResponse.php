<?php


namespace App\Helpers;


class ArrayToResponse
{
    /**
     * Trocas as chaves do array do DB que estão em snake_case para camelCase
     * para ser tratada pelo frontend
     *
     * @param array $array
     *
     * @return array
     */
    public static function prepare(array $array): array {
        $return = [];

        foreach($array as $key => $value) {
            // Faz um loop recursivo caso seja um resultado com relacionamentos
            if (is_array($value)) {
                $value = self::prepare($value);
            }

            // REGEX: Pega qualquer caractere de "a" a "z" que estiver após um _
            //        e converte para letra maiúscula
            $key = preg_replace_callback('/_([a-z]*)/', function($matches) {
                return ucfirst($matches[1]);
            }, $key);

            $return[$key] = $value;
        }

        return $return;
    }
}
