<script setup>
import {defineEmits} from 'vue'
import {useRouter} from "vue-router"
import trediumLogo from "@/assets/images/tredium_logo_tp_white.png";

const router = useRouter()
const emit = defineEmits(['sidebar-drawer'])
const sidebarDrawer = () => {
    emit('sidebar-drawer')
}

const goToHome = () => {
    router.push({name: "dashboard"})
}
</script>

<template>
    <v-app-bar
        scroll-behavior="elevate"
        location="top"
        class="bg-grey-lighten-5x"
    >
        <v-container class="d-flex justify-space-between align-center" fluid>
            <div class="d-flex align-center">
                <v-app-bar-nav-icon @click="sidebarDrawer" />
                <v-toolbar-title>Admin panel</v-toolbar-title>
            </div>
            <v-btn
                color="primary"
                @click="goToHome"
            >
                Home
            </v-btn>
        </v-container>
    </v-app-bar>
</template>
