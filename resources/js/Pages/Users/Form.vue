<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    form: Object,
});
const emits = defineEmits(["submitForm"]);
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
                autocomplete="current-password"
            />

            <InputError :message="form.errors.name" class="mt-2" />
        </div>

        <div>
            <InputLabel for="email" value="E-mail" />

            <TextInput
                id="email"
                v-model="form.email"
                type="email"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <InputError :message="form.errors.email" class="mt-2" />
        </div>

        <div>
            <InputLabel for="password" value="Senha" />

            <TextInput
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />

            <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

            <Transition
                enter-from-class="opacity-0"
                leave-to-class="opacity-0"
                class="transition ease-in-out"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                    Salvo.
                </p>
            </Transition>
        </div>
    </form>
</template>
