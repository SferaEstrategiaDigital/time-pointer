<template>
    <div class="py-2">
        <div class="mx-auto sm:px-6 lg:px-8 grid grid-cols-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="p-6 text-gray-900 text-3xl">
                    {{ imovel.endereco }}
                </h1>
                <h2 class="p-6 pt-3 text-2xl">
                    {{ imovel.property_type }}
                </h2>
                <p>
                    {{ imovel.price }}
                </p>
                <p class="whitespace-pre">{{ imovel }}</p>
            </div>
            <div v-if="imovel.fotos?.length" class="p-4">
                <ul class="flex flex-wrap gap-4">
                    <li v-for="foto in imovel.fotos" class="w-full">
                        <img
                            :src="`https://venda-imoveis.caixa.gov.br${foto}`"
                            :alt="imovel.endereco"
                            class="max-w-full max-h-60 object-cover mx-auto"
                        />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    imovel: Object,
});
</script>

<style scoped></style>
