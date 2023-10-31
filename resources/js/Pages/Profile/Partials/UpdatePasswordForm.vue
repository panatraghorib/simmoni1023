<script setup>
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import InputError from "@/Components/InputError.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import { mdiBallotOutline, mdiAccount, mdiKeyArrowRight } from "@mdi/js";

import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="mt-4">
        <CardBox is-form has-outline @submit.prevent="updatePassword">
            <header>
                <h2 class="text-lg font-medium text-blue-700">
                    Pengubahan Kata Sandi
                </h2>

                <p class="mt-1 mb-3 text-sm text-gray-500">
                    Pastikan akun Anda menggunakan kata sandi yang panjang dan
                    acak agar tetap aman.
                </p>
            </header>
            <FormField label="Kata sandi lama">
                <FormControl
                    v-model="form.current_password"
                    type="password"
                    :icon="mdiKeyArrowRight"
                />
            </FormField>
            <InputError class="mt-2" :message="form.errors.current_password" />

            <FormField
                label="Kata sandi baru"
                help="Do not enter the leading zero"
            >
                <FormControl
                    v-model="form.password"
                    type="password"
                    placeholder="New Password"
                />
            </FormField>
            <InputError class="mt-2" :message="form.errors.password" />

            <FormField label="Konfirmasi Kata sandi">
                <FormControl
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="Konfirmasi Password"
                />
            </FormField>
            <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
            />
            <template #footer>
                <BaseButtons>
                    <BaseButton
                        type="submit"
                        color="success"
                        label="Submit"
                        roundedFull
                        small
                        :disabled="form.processing"
                    />
                    <BaseButton
                        type="reset"
                        color="success"
                        outline
                        label="Reset"
                        roundedFull
                        small
                    />
                </BaseButtons>
            </template>
        </CardBox>
    </section>
</template>
