<?php

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
