<script setup>
import { mdiBookCheck } from "@mdi/js";
import BaseButton from "@/components/BaseButton.vue";
import SectionBanner from "@/components/SectionBanner.vue";
import { gradientBgBlueRed } from "@/colors";
</script>

<template>
    <SectionBanner :class="gradientBgBlueRed">
        <h1 class="text-3xl text-white mb-6">
            Like the project? Please star on <b>Appste</b> ;-)
        </h1>
        <div>
            <BaseButton
                href="#"
                :icon="mdiBookCheck"
                label="Lets Star"
                target="_blank"
                rounded-full
            />
        </div>
    </SectionBanner>
</template>
