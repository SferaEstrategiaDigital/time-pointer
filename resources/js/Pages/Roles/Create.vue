<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Form from "./Form.vue";

const form = useForm({
    name: "",
    permissions: [],
});

const create = () => {
    form.post(route("papeis.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Nova Permissão" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nova Permissão
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    !{{ form }}!
                    <Form :form="form" @submitForm="create" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
