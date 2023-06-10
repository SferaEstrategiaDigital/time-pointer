<template>
    <div class="bg-gray-100">
        <div class="p-6 bg-white rounded shadow w-full">
            <div class="mt-8">
                <div class="relative">
                    <input
                        class="w-full pl-10 pr-4 py-2 rounded-lg shadow border-0 outline-none ring-green-800 font-medium"
                        type="search"
                        placeholder="Buscar por imóvel"
                        v-model="searchInput"
                    />
                    <div class="absolute left-0 top-0 mt-2 ml-3">
                        <i
                            class="fas fa-search text-gray-400 z-20 hover:text-gray-500"
                        ></i>
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-4 w-2/6 mx-auto">
                <button
                    class="bg-orange-500 text-white font-bold p-2 rounded hover:bg-orange-600"
                    @click="search()"
                >
                    Estou com sorte
                </button>
                <button
                    class="bg-orange-500 text-white font-bold p-2 rounded hover:bg-orange-600"
                    @click="search()"
                >
                    Pesquisar
                </button>
            </div>
            <ResultList />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ResultList from "./ResultList.vue";

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
