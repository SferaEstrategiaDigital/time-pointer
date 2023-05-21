<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import PermissionWrapper from "@/Components/PermissionTree/TreeWrapper.vue";

const emits = defineEmits(["submitForm"]);

defineProps({
    form: Object,
});

const permissionTree = ref([]);

onMounted(() => {
    axios.get(route("papeis.tree")).then((res) => {
        if (res.status == 200) {
            permissionTree.value = res.data.data;
        }
    });
});
</script>
<template>
    <form @submit.prevent="emits('submitForm')" class="mt-6 space-y-6">
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

        <PermissionWrapper :data="permissionTree" />
    </form>
</template>
