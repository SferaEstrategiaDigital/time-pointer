<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import HomeDashboard from "@/Pages/Home/Dashboard.vue";
import HomeAcoes from "@/Pages/Home/Acoes.vue";
import { Head } from "@inertiajs/vue3";
import SearchWrapper from "@/Components/Search/Wrapper.vue";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- <div class="p-6 text-gray-900">Seja bem vindo</div> -->
                    <SearchWrapper />

                    <!-- <div class="p-6"><HomeDashboard /></div> -->
                    <!-- <div class="p-6"><HomeAcoes /></div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
