<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Form from "./Form.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    roles: [],
});

const create = () => {
    form.post(route("usuarios.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Novo Usuário" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Novo Usuário
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <Form :form="form" @submitForm="create" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
