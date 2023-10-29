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
            <ResultList @viewDetails="openModal" :items="searchResults" />

            <SimpleModal :isOpen="showModal" @close="showModal = false">
                <template #content>
                    <Detalhes :imovel="modalImovel" />
                </template>
            </SimpleModal>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import SimpleModal from "@/Components/SimpleModal.vue";
import axios from "axios";
import ResultList from "./ResultList.vue";
import Detalhes from "@/Components/Imoveis/Detalhes.vue";

let searchInput = ref("");

let searchResults = ref([]);

const showModal = ref(false);

const modalImovel = ref({});

const openModal = (data) => {
    // console.log(data);
    modalImovel.value = data;
    console.log(modalImovel.value);
    showModal.value = true;
};

const search = () => {
    console.log(`Pesquisando: ${searchInput.value}`);
    searchResults.value = [];
    axios
        .post(route("search"), {
            query: searchInput.value,
        })
        .then((r) => {
            searchResults.value = r.data.data.imoveis;
        })
        .finally(() => {
            console.log("FIM");
        });
};
</script>
