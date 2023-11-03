<template>
    <div class="py-2">
        <div class="mx-auto sm:px-6 lg:px-8 grid grid-cols-2">
            <div
                class="overflow-hidden shadow-sm sm:rounded-lg bg-slate-400/40 px-3 py-2"
            >
                <table>
                    <tbody>
                        <!-- Instituição -->
                        <tr>
                            <td>Instituição</td>
                            <td>Caixa Econômica Federal</td>
                        </tr>

                        <!-- Número do Imovel -->
                        <tr>
                            <td>Número do Imovel</td>
                            <td>{{ imovel.num_imovel }}</td>
                        </tr>

                        <!-- Endereço -->
                        <tr>
                            <td>Endereço</td>
                            <td>{{ imovel.endereco }}</td>
                        </tr>

                        <!-- Tipo -->
                        <tr>
                            <td>Tipo</td>
                            <td>{{ imovel.property_type }}</td>
                        </tr>

                        <!-- Valor do imóvel -->
                        <tr>
                            <td>Valor do imóvel</td>
                            <td>{{ imovel.price }}</td>
                        </tr>

                        <!-- Situação -->
                        <tr>
                            <td>Situação</td>
                            <td>
                                {{ imovel.situacao ? "Ocupado" : "Desocupado" }}
                            </td>
                        </tr>

                        <!-- Cidade/ Estado -->
                        <tr>
                            <td>Cidade/ Estado</td>
                            <td>
                                {{ imovel.cidade }}/<span class="uppercase">{{
                                    imovel.estado
                                }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Link de acesso ao site da caixa -->
                <a
                    class="px-1 py-2 my-2 rounded border inline-block"
                    :href="`${link}/${imovel.num_imovel}`"
                    target="_blank"
                    rel="noopener noreferrer"
                    >Acesso o site da caixa</a
                >

                <!-- <p class="whitespace-pre">{{ imovel }}</p> -->
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
import { computed } from "vue";
const link =
    "https://venda-imoveis.caixa.gov.br/sistema/detalhe-imovel.asp?hdnOrigem=index&hdnimovel=";
const props = defineProps({
    imovel: Object,
});
</script>

<style scoped>
table td:nth-child(1) {
    @apply align-top;
}
table td:nth-child(2) {
    @apply text-right;
}
</style>
