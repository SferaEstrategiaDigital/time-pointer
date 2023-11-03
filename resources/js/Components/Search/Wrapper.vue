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
                        @keydown.enter="btnSearch"
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
                    @click="btnSearch()"
                >
                    Estou com sorte
                </button>
                <button
                    class="bg-orange-500 text-white font-bold p-2 rounded hover:bg-orange-600"
                    @click="btnSearch()"
                >
                    Pesquisar
                </button>
            </div>
            <ResultList
                @viewDetails="openModal"
                :meta="meta"
                :term="searchInputText"
                :loading="loading"
                @change-page="loadPage"
                :items="searchResults"
            />

            <SimpleModal :isOpen="showModal" @close="showModal = false">
                <template #content>
                    <div class="flex justify-end">
                        <button
                            @click="showModal = false"
                            class="bg-red-300 px-2 py-1 rounded-lg"
                        >
                            <i
                                class="fa fa-chevron-circle-left"
                                aria-hidden="true"
                            ></i>
                            Voltar
                        </button>
                    </div>
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

const searchInput = ref("");

const searchInputText = ref("");
const meta = ref({});

const searchResults = ref([]);

const showModal = ref(false);

const loading = ref(false);

const modalImovel = ref({});

const openModal = (data) => {
    modalImovel.value = data;
    console.log(modalImovel.value);
    showModal.value = true;
};

const btnSearch = async () => {
    loading.value = true;
    meta.value = {};
    searchResults.value = {};
    searchInputText.value = searchInput.value;
    const response = await search();
    searchResults.value = response.data.data;
    meta.value = response.data.meta;
    loading.value = false;
};

const search = async (page) => {
    const response = await axios.post(route("search"), {
        query: searchInputText.value,
        page: page ?? null,
    });

    return response;
};

const loadPage = async (page) => {
    console.log(page);
    loading.value = true;
    const response = await search(page);
    meta.value = response.data.meta;
    loading.value = false;
};
</script>
