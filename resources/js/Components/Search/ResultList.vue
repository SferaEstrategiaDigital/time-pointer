<template>
    <div class="flex space-x-6 pl-10 mt-4">
        <div
            class="flex flex-col bg-green-100 px-2 py-0.5 rounded-lg cursor-pointer"
            title="Clique aqui para alterar"
        >
            <div class="flex items-center">
                <span class="font-bold">Ordenar por:</span>
                <small class="ml-2">Apartamento</small>
            </div>
        </div>

        <div
            class="flex flex-col bg-green-100 px-2 py-0.5 rounded-lg cursor-pointer"
            title="Clique aqui para alterar"
        >
            <div class="flex items-center">
                <span class="font-bold">Valores entre:</span>
                <small class="ml-2">R$ 10000,00 e R$ 1000000,00</small>
            </div>
        </div>
    </div>
    <div class="grid gap-8 grid-cols-4">
        <ResultItem
            class="mt-4"
            v-for="(result, index) in searchResults"
            :key="index"
            :result="result"
        />
    </div>
</template>
<script setup>
import { ref } from "vue";
import ResultItem from "./ResultItem.vue";

let searchInput = ref("");

const search = () => {
    console.log(`Pesquisando: ${searchInput.value}`);
};

let searchResults = ref([
    {
        link: "/link-do-imovel",
        title: "Montalvânia / MG",
        property_type: "Casa",
        price: "R$ 312.750",
        discount: "55%",
        address: "RUA AGASSIS,N. 545  QD 04 LR 31, CENTRO",
        cep: "39495-000",
        city: "MONTALVANIA",
        state: "MG",
        areaUtil: "401",
        areaTotal: "300",
    },
    {
        link: "/link-do-imovel",
        title: "Montalvânia / MG",
        property_type: "Apartamento",
        price: "R$ 312.750",
        discount: "55%",
        address: "RUA AGASSIS,N. 545  QD 04 LR 31, CENTRO",
        cep: "39495-000",
        city: "MONTALVANIA",
        state: "MG",
        areaUtil: "401",
        areaTotal: "300",
    },
    {
        link: "/link-do-imovel",
        title: "Montalvânia / MG",
        property_type: "Terreno",
        price: "R$ 312.750",
        discount: "55%",
        address: "RUA AGASSIS,N. 545  QD 04 LR 31, CENTRO",
        cep: "39495-000",
        city: "MONTALVANIA",
        state: "MG",
        areaUtil: "401",
        areaTotal: "300",
    },
    {
        link: "/link-do-imovel",
        property_type: "Casa",
        price: "R$ 312.750",
        discount: "55%",
        address: "RUA AGASSIS,N. 545  QD 04 LR 31, CENTRO",
        cep: "39495-000",
        city: "MONTALVANIA",
        state: "MG",
        areaUtil: "401",
        areaTotal: "300",
    },
]);
</script>
