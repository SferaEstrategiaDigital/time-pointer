<script lang="ts"></script>

<template>
    <div class="grid grid-cols-12 gap-4">
        <a class="btn">
            <p>Busca Avançada</p>
        </a>
        <a class="btn">
            <p>Meus Imóveis Favoritos</p>
        </a>
        <a class="btn">
            <p>Imóveis em disputa</p>
        </a>
        <a class="btn">
            <p>Configurar alerta por e-mail</p>
        </a>
        <a class="btn">
            <p>Assinar Plano Premium</p>
        </a>
    </div>
</template>

<style scoped>
.btn {
    @apply col-span-12 p-2 bg-orange-600/70 text-green-800 font-bold text-xl rounded-md md:col-span-4 md:text-center md:p-4;
}
.btn p {
    @apply inline-block ml-2 md:block;
}
</style>
