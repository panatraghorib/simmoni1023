<script setup>
import { computed, ref, onMounted } from "vue";
import FormControlIcon from "@/Components/FormControlIcon.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { useDarkModeStore } from "@/Stores/darkMode";

const props = defineProps({
    name: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null,
    },
    autocomplete: {
        type: String,
        default: null,
    },
    maxlength: {
        type: String,
        default: null,
    },
    placeholder: {
        type: String,
        default: null,
    },
    inputmode: {
        type: String,
        default: null,
    },
    icon: {
        type: String,
        default: null,
    },
    options: {
        type: Array,
        default: null,
    },
    type: {
        type: String,
        default: "text",
    },
    modelValue: {
        type: [Date, String],
        default: "",
    },
    enableTimePicker: Boolean,
    required: Boolean,
    borderless: Boolean,
    transparent: Boolean,
    error: String,
});

const emit = defineEmits(["update:modelValue", "setRef"]);

const computedValue = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});

const darkModeStore = useDarkModeStore();

// const isDark = computed(() => darkModeStore.isEna)

const inputElClass = computed(() => {
    const base = [
        "max-w-full focus:ring-1 focus:outline-none border-gray-400 rounded w-full",
        "dark:placeholder-gray-400 focus:ring-emerald-200",
        computedType.value === "textarea" ? "h-24" : "h-10 text-sm",
        props.borderless ? "border-0" : "border",
        props.transparent ? "bg-transparent" : "bg-white dark:bg-slate-800",
    ];

    if (props.icon) {
        base.push("pl-10");
    }

    return base;
});

const controlIconH = computed(() => "h-10");

const inputEl = ref(null);

onMounted(() => {
    emit("setRef", inputEl.value);
});
</script>

<template>
    <div class="relative">
        <VueDatePicker
            v-model="computedValue"
            :uid="id"
            :dark="darkModeStore.isEnabled"
            :enableTimePicker="enableTimePicker"
            preview-format="dd/MM/yyyy"
            format="dd/MM/yyyy"
            :inputClassName="`h-10 text-sm border border-gray-400 dark:bg-slate-800 dark:border-slate-50/70`"
            auto-apply
        />
        <!-- <input
            :id="id"
            ref="inputEl"
            v-model="computedValue"
            :name="name"
            :maxlength="maxlength"
            :inputmode="inputmode"
            :autocomplete="autocomplete"
            :required="required"
            :placeholder="placeholder"
            :type="computedType"
            :class="inputElClass"
        /> -->
        <FormControlIcon v-if="icon" :icon="icon" :h="controlIconH" />
        <div v-if="error" class="form-error">
            <span class="text-xs italic text-red-500"> {{ error }}</span>
        </div>
    </div>
</template>
