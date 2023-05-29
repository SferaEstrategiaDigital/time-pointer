<script setup>
import { inject } from "vue";

const permissions = inject("permissions");
</script>

<template>
    <div class="grid grid-cols-12 gap-4">
        <a class="btn">
            <p>89653</p>
            <p>Imoveis</p>
        </a>
        <a class="btn">
            <p>89653</p>
            <p>Novos</p>
        </a>
        <a class="btn">
            <p>4</p>
            <p>Vendidos</p>
        </a>
    </div>
</template>

<style>
.btn {
    @apply col-span-12 bg-orange-600 text-green-800 font-bold text-xl rounded-md md:col-span-4 md:text-center md:p-4;
}
.btn p {
    @apply inline-block ml-2 md:block;
}
</style>
