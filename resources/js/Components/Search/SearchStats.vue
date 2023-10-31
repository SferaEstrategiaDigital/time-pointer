<template>
    <!-- Contêiner para as estatísticas da pesquisa -->
    <div class="search-stats bg-gray-100 p-4 rounded-md flex justify-between">
        <!-- Mostra a faixa de itens sendo exibida e o total de resultados -->
        <p>
            Mostrando resultados de <strong>{{ term }}</strong>
        </p>
        <p>
            <strong>{{ from }}</strong> a <strong>{{ to }}</strong> de
            <strong>{{ total }}</strong> resultados
        </p>
        <!-- Mostra o número da página atual e o total de páginas, se disponíveis -->
        <p v-if="currentPage && lastPage" class="mt-2">
            Página <strong>{{ currentPage }}</strong> de
            <strong>{{ lastPage }}</strong>
        </p>
    </div>
</template>

<script setup>
import { defineProps } from "vue";

// Define as propriedades que o componente espera receber
/**
 * @property {number} from - O número do primeiro item da página atual.
 * @property {number} to - O número do último item da página atual.
 * @property {number} total - O total de itens em todas as páginas.
 * @property {number} [currentPage] - O número da página atual (opcional).
 * @property {number} [lastPage] - O número da última página (opcional).
 */
const { from, to, total, currentPage, lastPage, term } = defineProps({
    from: Number,
    to: Number,
    total: Number,
    currentPage: Number,
    lastPage: Number,
    term: String,
});
</script>

<style>
p {
    @apply text-sm text-gray-600;
}
</style>
