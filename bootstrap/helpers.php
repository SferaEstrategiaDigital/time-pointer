<?php

if (!function_exists('replace')) {
    /**
     * Replace string or pattern in a string.
     *
     * @param  mixed  $search
     * @param  mixed  $replace
     * @param  string  $subject
     * @return string
     */
    function replace($search, $replace, $subject)
    {
        // Se $search for uma expressão regular
        if (is_string($search) && @preg_match($search, '') !== false) {
            // Se $replace for uma função de callback
            if (is_callable($replace)) {
                return preg_replace_callback($search, $replace, $subject);
            }

            // Se $replace for uma string ou array
            return preg_replace($search, $replace, $subject);
        }

        // Comportamento padrão de substituição de string
        return str_replace($search, $replace, $subject);
    }
}


if (!function_exists('capitalizer')) {
    /**
     * Formata o nome da cidade capitalizando a primeira letra de cada palavra, exceto preposições.
     *
     * @param string $nome Nome da cidade a ser formatado.
     * @return string Nome da cidade formatado.
     */
    function capitalizer(string $nome): string
    {
        // Divide a string de entrada em um array de palavras usando espaços como delimitadores.
        return implode(' ', array_map( // Junta o array de palavras novamente em uma string usando espaços.
            fn ($palavra) =>
            // Verifica se a palavra (convertida para minúsculas e mantendo acentuação) está na lista de palavras para não capitalizar.
            in_array(mb_strtolower($palavra, 'UTF-8'), ['do', 'da', 'de', 'e', 'dos', 'das'])
                ? mb_strtolower($palavra, 'UTF-8')  // Se estiver na lista, mantém a palavra em minúsculas.
                : mb_convert_case(mb_strtolower($palavra, 'UTF-8'), MB_CASE_TITLE, 'UTF-8'),  // Caso contrário, capitaliza a primeira letra da palavra.
            explode(' ', $nome)  // Divide a string de entrada em um array de palavras usando espaços como delimitadores.
        ));
    }
}
