<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";

defineProps({
    imovel: Object,
});
</script>

<template>
    <Head title="Detalhes" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h1 class="p-6 text-gray-900 text-3xl">
                        {{ imovel.data.endereco }}
                    </h1>
                    <h2 class="p-6 pt-3 text-2xl">
                        {{ imovel.data.property_type }}
                    </h2>
                    <p>
                        {{ imovel.data.price }}
                    </p>
                    <p class="whitespace-pre">{{ imovel.data }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
