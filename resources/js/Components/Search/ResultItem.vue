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
                >Desconto<br />{{ result.discount }}
                <i class="fas fa-long-arrow-alt-down"></i
            ></span>
        </div>
        <h2 class="mt-2 font-semibold text-lg">
            <a :href="result.link" class="text-gray-900 hover:text-gray-600"
                >{{ result.city }} / {{ result.state }}</a
            >
        </h2>
        <div class="infos">
            <a
                :href="result.link"
                class="text-gray-600 hover:text-gray-900 text-sm"
            >
                <div><i class="flaticon-pin"></i>{{ result.address }}</div>
                <div><span>CEP:</span> {{ result.cep }}</div>
            </a>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    result: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
.card {
    @apply flex flex-col bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto;
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
