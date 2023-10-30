<script setup>
import { reactive, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import {
    mdiBallotOutline,
    mdiAccount,
    mdiAccountMultiplePlusOutline,
    mdiArrowLeftCircle,
    mdiMail,
} from "@mdi/js";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import CardBox from "@/Components/CardBox.vue";

import BaseButton from "@/Components/BaseButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import FormDatePicker from "@/Components/FormDatePicker.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

// const selectOptions = [
//     { id: 1, label: "Business development" },
//     { id: 2, label: "Marketing" },
//     { id: 3, label: "Sales" },
// ];

const data = defineProps({ roles: Object, cabor: Object });

const namaLengkap = ref(null);

const form = useForm({
    username: "vella_dar",
    email: "vela.dar@gmail.com",
    name: "Vella Darpa",
    password: "12345678",
    password_confirmation: "12345678",
    mobile: "085327889876",
    dateOfBirth: "10/05/1993",
    gender: "",
    avatar: null,
    roles: "",
    cabor: "",
});

const onRoleChange = (role) => {
    if (form.roles && form.roles.label !== 'Organisasi/Cabor') {
        form.cabor = "";
    }
};

function submit() {
    form.post(route("user.store"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.name) {
                form.reset("name");
                namaLengkap.value.focus();
            }
            if (form.errors.username) {
                form.reset("username");
            }
        },
    });
}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Create User" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiAccountMultiplePlusOutline"
                title="User Baru"
            >
                <BaseButton
                    route-name="user.index"
                    :icon="mdiArrowLeftCircle"
                    label="Back to Dashboard"
                    color="light"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <CardBox form @submit.prevent="submit" is-form>
                <FormField label="Nama Lengkap">
                    <FormControl
                        v-model="form.name"
                        :icon="mdiBallotOutline"
                        ref="namaLengkap"
                        :error="form.errors.name"
                    />
                </FormField>

                <FormField label="Username">
                    <FormControl
                        v-model="form.username"
                        :icon="mdiAccount"
                        :error="form.errors.username"
                    />
                </FormField>

                <FormField label="Email">
                    <FormControl
                        v-model="form.email"
                        :icon="mdiMail"
                        :error="form.errors.email"
                    />
                </FormField>

                <div class="grid gap-6 md:grid-cols-2">
                    <FormField
                        label="Kata sandi"
                        help="Sertakan karekter Huruf Kapital, Angka, dan Karakter Spesial"
                    >
                        <FormControl
                            v-model="form.password"
                            type="password"
                            placeholder="kata sandi baru"
                            :error="form.errors.password"
                        />
                    </FormField>

                    <FormField label="Konfirmasi Kata sandi">
                        <FormControl
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="konfirmasi kata sandi"
                            :error="form.errors.password_confirmation"
                        />
                    </FormField>
                </div>
                <div class="grid gap-6 md:grid-cols-2">
                    <FormField label="Kontak">
                        <FormControl
                            v-model="form.mobile"
                            :error="form.errors.mobile"
                        />
                    </FormField>
                    <FormField label="Tanggal Lahir">
                        <FormDatePicker
                            v-model="form.dateOfBirth"
                            :enableTimePicker="false"
                            :error="form.errors.date_of_birth"
                        />
                    </FormField>
                </div>
                <FormField label="Jenis Kelamin" class="w-1/2">
                    <FormControl
                        v-model="form.gender"
                        :options="[
                            { id: 'Laki-Laki', label: 'Laki-Laki' },
                            { id: 'Perempuan', label: 'Perempuan' },
                        ]"
                        name="Jenis Kelamin"
                        :error="form.errors.gender"
                    />
                </FormField>

                <FormField label="Foto">
                    <FormFilePicker
                        v-model="form.avatar"
                        label="Upload"
                        accept=".jpg,.png"
                        small
                        preview
                        isRoundIcon
                    />
                </FormField>

                <BaseDivider />
                <FormField label="Hak Akses">
                    <FormControl
                        v-model="form.roles"
                        :options="data.roles"
                        name="hak akses"
                        :error="form.errors.roles"
                        @change="onRoleChange"
                    />
                </FormField>
                <div v-if="form.roles && form.roles.label == 'Organisasi/Cabor'">
                    <FormField label="Organisasi/Cabor">
                        <FormControl
                            v-model="form.cabor"
                            :options="data.cabor"
                            name="Cabor"
                            :error="form.errors.cabor"
                        />
                    </FormField>
                </div>

                <BaseDivider />

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="text-white bg-emerald-600 border-emerald-700 shadow-md dark:bg-purple-600 dark:border-purple-700"
                            label="Submit"
                            small
                        />
                        <BaseButton
                            type="reset"
                            color="danger"
                            outline
                            label="Reset"
                            small
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
