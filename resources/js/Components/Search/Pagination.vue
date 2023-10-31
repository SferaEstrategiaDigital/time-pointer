<template>
    <!-- Contêiner flexível para centralizar os itens -->
    <div class="flex items-center justify-center">
        <!-- Botão "Primeira" -->
        <!-- @click define o manipulador de clique que muda para a primeira página -->
        <!-- :disabled desativa o botão se estivermos na primeira página -->
        <button
            @click="changePage(1)"
            :disabled="currentPage === 1"
            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Primeira
        </button>

        <!-- Botão "Anterior" -->
        <!-- Muda para a página anterior -->
        <button
            @click="changePage(currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Anterior
        </button>

        <!-- Loop através das páginas para mostrar os números -->
        <span
            v-for="page in pages"
            :key="page"
            :class="{ 'bg-blue-500 text-white': page === currentPage }"
            class="mx-1 px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 cursor-pointer"
            @click="changePage(page)"
        >
            {{ page }}
        </span>

        <!-- Botão "Próximo" -->
        <!-- Muda para a próxima página -->
        <button
            @click="changePage(currentPage + 1)"
            :disabled="currentPage === lastPage"
            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Próximo
        </button>

        <!-- Botão "Última" -->
        <!-- Muda para a última página -->
        <button
            @click="changePage(lastPage)"
            :disabled="currentPage === lastPage"
            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Última
        </button>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, computed } from "vue";

// Define as propriedades que o componente espera receber
/**
 * @property {number} currentPage - A página atual.
 * @property {number} lastPage - O número da última página.
 */
const { currentPage, lastPage } = defineProps(["currentPage", "lastPage"]);

// Define os eventos que o componente pode emitir
const emits = defineEmits(["change-page"]);

/**
 * Muda para a página especificada.
 * @param {number} page - O número da página para mudar.
 */
const changePage = (page) => {
    emits("change-page", page);
};

/**
 * Calcula quais números de página devem ser mostrados.
 * Mostra a página atual, duas páginas antes e duas depois.
 * Ajusta os números para evitar valores fora do range válido.
 * @returns {Array<number>} - Uma lista de números de página a serem mostrados.
 */
const pages = computed(() => {
    let min = currentPage - 2;
    let max = currentPage + 2;

    // Ajusta se o valor mínimo for menor que 1
    if (min < 1) {
        max += Math.abs(min) + 1;
        min = 1;
    }

    // Ajusta se o valor máximo for maior que a última página
    if (max > lastPage) {
        min = Math.max(min - (max - lastPage), 1);
        max = lastPage;
    }

    const result = [];
    for (let i = min; i <= max; i++) {
        result.push(i);
    }
    return result;
});
</script>
