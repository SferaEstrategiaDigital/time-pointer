<template>
    <div class="card">
        <div class="header">
            <span
                class="inline-block bg-blue-600 text-white text-xs px-2 rounded-full uppercase font-semibold tracking-wide"
                >{{ result.property_type }}</span
            >
            <small
                class="text-2xl text-green-800 cursor-pointer"
                title="Favoritar"
                >&hearts;</small
            >
        </div>
        <div class="flex text-gray-600 text-sm w-full justify-between mt-3">
            <span class="font-bold text-gray-900"
                >Valor: <br />{{ result.price }}</span
            >
            <span class="ml-2 text-right"
                >Desconto<br />{{
                    result.desconto.toString().replace(".", ",")
                }}
                <i class="fas fa-long-arrow-alt-down"></i
            ></span>
        </div>
        <h2 class="mt-2 font-semibold text-lg">
            <span class="text-gray-900 hover:text-gray-600">
                <span class="capitalize">{{ result.cidade }}</span> /
                <span class="uppercase">{{ result.estado }}</span>
            </span>
        </h2>
        <div class="infos">
            <span class="text-gray-600 hover:text-gray-900 text-sm">
                <div><i class="flaticon-pin"></i>{{ result.endereco }}</div>
                <div><span>CEP:</span> {{ result.cep }}</div>
            </span>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    result: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
.card {
    @apply flex flex-col bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto cursor-pointer;
}

.card .header {
    @apply flex justify-between items-baseline;
}

.card .infos {
    @apply mt-2;
}

.card .infos div {
    @apply mt-1;
}
.card .infos div span {
    @apply font-bold text-black;
}
</style>
