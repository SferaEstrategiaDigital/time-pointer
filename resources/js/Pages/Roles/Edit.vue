<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Form from "./Form.vue";

const props = defineProps({
    funcao: Object,
});

const form = useForm({
    name: props.funcao.data.titulo,
    permissions: props.funcao.data.permissoes.map((v) => v.id),
});

const update = () => {
    form.put(route("funcoes.update", [props.funcao.data.id]), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Alterar usuário " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alterar {{ form.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <Form :form="form" @submitForm="update" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
