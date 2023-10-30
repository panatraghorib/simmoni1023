<script setup>
import { ref } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import {
    mdiBallotOutline,
    mdiAccount,
    mdiMail,
    mdiMonitorDashboard,
} from "@mdi/js";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import FormControl from "@/Components/FormControl.vue";
import FormField from "@/Components/FormField.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import InputError from "@/Components/InputError.vue";

import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import FormFilePicker from "@/Components/FormFilePicker.vue";
import SectionTitle from "@/Components/SectionTitle.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const profileForm = useForm({
    name: user.name,
    email: user.email,
});

const formStatusCurrent = ref(0);

const formStatusOptions = ["info", "success", "danger", "warning"];

const formStatusSubmit = () => {
    formStatusCurrent.value = formStatusOptions[formStatusCurrent.value + 1]
        ? formStatusCurrent.value + 1
        : 0;
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Profile" />

        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiBallotOutline"
                title="Edit Profile"
            >
                <BaseButton
                    route-name="dashboard"
                    :icon="mdiMonitorDashboard"
                    label="Back to Dashboard"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox
                is-form
                has-outline
                @submit.prevent="profileForm.patch(route('profile.update'))"
            >
                <FormField label="Email">
                    <FormControl
                        v-model="profileForm.email"
                        type="email"
                        :icon="mdiMail"
                    />
                </FormField>

                <FormField label="Name" help="Do not enter the leading zero">
                    <FormControl
                        v-model="profileForm.name"
                        type="tel"
                        placeholder="Your Name"
                    />
                </FormField>
                <InputError class="mt-2" :message="profileForm.errors.name" />

                <BaseDivider />

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="info"
                            label="Submit"
                            roundedFull
                            small
                            :disabled="profileForm.processing"
                        />
                        <BaseButton
                            type="reset"
                            color="info"
                            outline
                            label="Reset"
                            roundedFull
                            small
                        />
                    </BaseButtons>
                </template>
            </CardBox>
            <UpdatePasswordForm />
        </SectionMain>
    </LayoutAuthenticated>
</template>
