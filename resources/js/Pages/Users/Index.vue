<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({
    users: Object,
});
const hoveredIndex = ref(null);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuários
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-3 flex justify-end">
                        <Link
                            :href="route('usuarios.create')"
                            class="border border-green-800 hover:bg-green-600 hover:border-green-600 hover:text-white rounded-md px-3 py-2 font-bold"
                        >
                            Novo Cliente
                        </Link>
                    </div>
                    <div class="p-6">
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">&nbsp;</th>
                                    <th class="px-4 py-2">Nome</th>
                                    <th class="px-4 py-2">E-mail</th>
                                    <th class="px-4 py-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users" :key="index">
                                    <td class="border px-4 py-2">
                                        <input
                                            type="checkbox"
                                            v-model="user.checked"
                                        />
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.email }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <div
                                            class="dropdown inline-block relative group"
                                        >
                                            <button
                                                class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center"
                                            >
                                                <span class="mr-1">Opções</span>
                                                <svg
                                                    class="fill-current h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path
                                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                                    />
                                                </svg>
                                            </button>
                                            <ul
                                                class="group-hover:block absolute hidden text-gray-700 pt-1 z-10"
                                            >
                                                <li class="">
                                                    <Link
                                                        class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                                                        :href="
                                                            route(
                                                                'usuarios.edit',
                                                                user.id
                                                            )
                                                        "
                                                        >Editar</Link
                                                    >
                                                </li>
                                                <li class="">
                                                    <a
                                                        class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                                                        href="#"
                                                        >Apagar</a
                                                    >
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
