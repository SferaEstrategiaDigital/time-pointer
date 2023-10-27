<template>
    <div class="bg-gray-100">
        <div class="p-6 bg-white rounded shadow w-full">
            <div class="mt-5">
                <div class="relative">
                    <input
                        class="w-full pl-10 pr-4 py-2 rounded-lg shadow border border-slate-900 hover:border-orange-700 outline-none ring-green-800 font-medium"
                        type="search"
                        placeholder="Buscar por imóvel, cidade, tipo de imóvel e estado"
                        v-model="searchInput"
                        @keydown.enter="search"
                    />
                    <div class="absolute left-0 top-0 mt-2 ml-3">
                        <i
                            class="fas fa-search text-gray-400 z-20 hover:text-gray-500"
                        ></i>
                    </div>
                </div>
            </div>
            <div
                class="flex justify-evenly md:justify-between mt-4 w-full md:w-2/6 mx-auto"
            >
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
            <ResultList :items="searchResults" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import ResultList from "./ResultList.vue";

let searchInput = ref("");

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
]);

const search = () => {
    console.log(`Pesquisando: ${searchInput.value}`);
    axios
        .post(route("search"), {
            query: searchInput.value,
        })
        .then((r) => {
            console.log(searchResults.value);
            searchResults.value = [];
            console.log(r.data.data.imoveis);
            r.data.data.imoveis.map((imovel) => {
                console.log(imovel);
                searchResults.value.push({
                    link: "/link-do-imovel",
                    situacao: imovel.situacao,
                    title: imovel.cidade,
                    property_type: imovel.property_type,
                    price: imovel.price,
                    discount: imovel.desconto.toString().replace(".", ","),
                    address: imovel.endereco,
                    cep: imovel.cep,
                    city: imovel.cidade,
                    state: imovel.estado,
                    areaUtil: "401",
                    areaTotal: "300",
                });
            });
        })
        .finally(() => {
            console.log("FIM");
        });
};
</script>
