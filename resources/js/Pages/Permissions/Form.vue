<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { onMounted, ref } from "vue";
import axios from "axios";

defineProps({
    form: Object,
});

const parentPermissions = ref([]);

onMounted(() => {
    axios.get(route("permissoes.getPermissions")).then((response) => {
        if (response.status == 200) {
            parentPermissions.value = response.data.data;
        }
    });
});
const emits = defineEmits(["submitForm"]);
</script>
<template>
    <form @submit.prevent="emits('submitForm')" class="mt-6 space-y-6">
        <div>
            <InputLabel for="pai" value="Permisssão pai" />

            <SelectInput
                id="pai"
                v-model="form.parent"
                class="mt-1 block w-full"
            >
                <option :value="perm.id" v-for="perm in parentPermissions">
                    {{ perm.caminho }}
                </option>
            </SelectInput>

            <InputError :message="form.errors.password" class="mt-2" />
        </div>
        <div>
            <InputLabel for="name" value="Nome" />

            <TextInput
                id="name"
                ref="currentPasswordInput"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
            />

            <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>
        </div>
    </form>
</template>
