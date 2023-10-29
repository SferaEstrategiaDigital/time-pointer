<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import Detalhes from "../../Components/Imoveis/Detalhes.vue";

defineProps({
    imovel: Object,
});
</script>

<template>
    <Head title="Detalhes" />

    <AuthenticatedLayout>
        <Detalhes :imovel="imovel.data" />
    </AuthenticatedLayout>
</template>
