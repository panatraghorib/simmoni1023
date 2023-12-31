<script setup>
import { mdiForwardburger, mdiBackburger, mdiMenu } from "@mdi/js";
import { ref } from "vue";
import menuNavBar from "@/menuNavBar.js";
import NavBar from "@/Components/Navbar/NavBar.vue";
import NavBarItemPlain from "@/Components/Navbar/NavBarItemPlain.vue";
import { useDarkModeStore } from "@/Stores/darkMode.js";
import BaseIcon from "@/Components/BaseIcon.vue";
import FormControl from "@/Components/FormControl.vue";
import menuAside from "@/menuAside.js";
import AsideMenu from "@/Components/AsideMenu/AsideMenu.vue";
import FooterBar from "@/Components/FooterBar.vue";

const layoutAsidePadding = "xl:pl-60";

const darkModeStore = useDarkModeStore();

const isAsideMobileExpanded = ref(false);
const isAsideLgActive = ref(false);

import { router } from "@inertiajs/vue3";

router.on("navigate", () => {
    isAsideMobileExpanded.value = false;
    isAsideLgActive.value = false;
});

const menuClick = (event, item) => {
    if (item.isToggleLightDark) {
        darkModeStore.set();
    }

    if (item.isLogout) {
        router.post(route("logout"));
    }
};
</script>

<template>
    <div
        :class="{
            'overflow-hidden lg:overflow-visible': isAsideMobileExpanded,
        }"
    >
        <div
            :class="[
                layoutAsidePadding,
                { 'ml-60 lg:ml-0': isAsideMobileExpanded },
            ]"
            class="pt-14 min-h-screen w-screen transition-position lg:w-auto bg-gray-50 dark:bg-slate-800 dark:text-slate-100"
        >
            <NavBar
                :menu="menuNavBar"
                :class="[
                    layoutAsidePadding,
                    { 'ml-60 lg:ml-0': isAsideMobileExpanded },
                ]"
                @menu-click="menuClick"
            >
                <NavBarItemPlain
                    display="flex lg:hidden"
                    @click.prevent="
                        isAsideMobileExpanded = !isAsideMobileExpanded
                    "
                >
                    <BaseIcon
                        :path="
                            isAsideMobileExpanded
                                ? mdiBackburger
                                : mdiForwardburger
                        "
                        size="24"
                    />
                </NavBarItemPlain>
                <NavBarItemPlain
                    display="hidden lg:flex xl:hidden"
                    @click.prevent="isAsideLgActive = true"
                >
                    <BaseIcon :path="mdiMenu" size="24" />
                </NavBarItemPlain>
                <NavBarItemPlain use-margin>
                    <FormControl
                        placeholder="Search (ctrl+k)"
                        ctrl-k-focus
                        transparent
                        borderless
                        class="border border-slate-200 rounded-md dark:border-slate-50/5 focus:border-slate-100"
                    />
                </NavBarItemPlain>
            </NavBar>
            <AsideMenu
                :is-aside-mobile-expanded="isAsideMobileExpanded"
                :is-aside-lg-active="isAsideLgActive"
                :menu="menuAside"
                @menu-click="menuClick"
                @aside-lg-close-click="isAsideLgActive = false"
            />
            <slot />
            <FooterBar />
        </div>
    </div>
</template>
