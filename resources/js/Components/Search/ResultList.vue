<template>
    <div class="hidden md:flex space-x-6 pl-10 mt-4">
        <div
            class="flex flex-col items-start bg-green-100 px-2 py-0.5 rounded-lg"
        >
            <Tooltip class="flex items-center">
                <template #title>
                    <span class="font-bold">Ordenar por:</span
                    ><span class="ml-2">{{
                        filterItems.order.title
                    }}</span></template
                >
                <template #content>
                    <ul
                        class="bg-white rounded-lg overflow-hidden mt-2 space-y-1"
                    >
                        <li
                            v-for="item in filters.order"
                            class="list-item"
                            @click="filter('order', item.id)"
                        >
                            {{ item.title }}
                        </li>
                    </ul>
                </template>
            </Tooltip>
        </div>

        <div
            class="flex flex-col px-2 py-0.5 bg-green-100 rounded-lg cursor-pointer relative min-w-[20rem]"
            title="Clique aqui para alterar"
        >
            <Tooltip class="flex items-center" :click-to-show="true">
                <template #title>
                    <span class="font-bold">Valores entre:</span>
                    <small class="ml-2" v-if="filterItems.priceBetween[0]"
                        >R$
                        {{
                            Number(
                                filterItems.priceBetween[0].replace(",", ".")
                            )
                                .toFixed(2)
                                .replace(".", ",")
                        }}</small
                    >
                    <small v-if="filterItems.priceBetween[1]">
                        e R$
                        {{
                            Number(
                                filterItems.priceBetween[1].replace(",", ".")
                            )
                                .toFixed(2)
                                .replace(".", ",")
                        }}</small
                    ></template
                >
                <template #content>
                    <div class="flex w-full">
                        <InputMaskMoney
                            class="w-1/2"
                            placeholder="R$ "
                            v-model="filterItems.priceBetween[0]"
                        />
                        <InputMaskMoney
                            class="w-1/2"
                            placeholder="R$ "
                            v-model="filterItems.priceBetween[1]"
                        />
                    </div>
                </template>
            </Tooltip>
        </div>
    </div>
    <div
        class="grid md:gap-8 gap-3 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
    >
        <ResultItem
            @click="$emit('viewDetails', result)"
            class="mt-4"
            v-for="(result, index) in items"
            :key="index"
            :result="result"
        />
    </div>
</template>
<script setup>
import { ref } from "vue";
import ResultItem from "./ResultItem.vue";
import Tooltip from "../Tooltip.vue";

import InputMaskMoney from "../InputMaskMoney.vue";

const props = defineProps({
    items: Object,
});

const emit = defineEmits(["viewDetails"]);

let searchInput = ref("");

const filters = ref({
    order: [
        {
            id: "menor_valor",
            title: "Menor valor",
        },
        {
            id: "maior_valor",
            title: "Maior valor",
        },
        {
            id: "mais_relevantes",
            title: "Mais relevantes",
        },
        {
            id: "menor_desconto",
            title: "Menor desconto",
        },
        {
            id: "maior_desconto",
            title: "Maior desconto",
        },
    ],
});

const filterItems = ref({
    order: filters.value.order[0],
    priceBetween: [0, 0],
});

const filter = (id, option) => {
    filterItems.value[id] = filters.value[id].filter((v) => v.id === option)[0];
};
</script>

<style scoped>
.list-item {
    @apply p-1 box-border border bg-green-600 cursor-pointer;
}
</style>
