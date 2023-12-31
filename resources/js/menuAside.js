import {
    mdiAccountCircle,
    mdiMonitor,
    mdiGithub,
    mdiLock,
    mdiAlertCircle,
    mdiSquareEditOutline,
    mdiTable,
    mdiViewList,
    mdiTelevisionGuide,
    mdiResponsive,
    mdiPalette,
    mdiAccountGroup,
} from "@mdi/js";

export default [
    {
        route: "dashboard",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        route: "user.index",
        icon: mdiAccountGroup,
        label: "Users",
    },
    // {
    //     to: "/tables",
    //     label: "Tables",
    //     icon: mdiTable,
    // },
    // {
    //     route: "forms",
    //     label: "Forms",
    //     icon: mdiSquareEditOutline,
    // },
    // {
    //     to: "/ui",
    //     label: "UI",
    //     icon: mdiTelevisionGuide,
    // },
    // {
    //     to: "/responsive",
    //     label: "Responsive",
    //     icon: mdiResponsive,
    // },
    // {
    //     to: "/",
    //     label: "Styles",
    //     icon: mdiPalette,
    // },
    // {
    //     to: "/profile",
    //     label: "Profile",
    //     icon: mdiAccountCircle,
    // },
    // {
    //     to: "/login",
    //     label: "Login",
    //     icon: mdiLock,
    // },
    // {
    //     to: "/error",
    //     label: "Error",
    //     icon: mdiAlertCircle,
    // },
    // {
    //     label: "Dropdown",
    //     icon: mdiViewList,
    //     menu: [
    //         {
    //             label: "Item One",
    //         },
    //         {
    //             label: "Item Two",
    //         },
    //     ],
    // },
    // {
    //     href: "#",
    //     label: "GitHub",
    //     icon: mdiGithub,
    //     target: "_blank",
    // },
];
