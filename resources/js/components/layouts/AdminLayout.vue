<script setup>
import Header from "@/components/admin/common/Header.vue"
import Sidebar from "@/components/admin/common/Sidebar.vue"
import {ref} from "vue"

const drawer = ref(true)
</script>

<template>
    <v-app>
        <Header @sidebar-drawer="drawer=!drawer"/>

        <v-navigation-drawer
            v-model="drawer"
            location="left"
            app
            width="240"
        >
            <Sidebar/>
        </v-navigation-drawer>

        <v-main>
            <router-view/>
        </v-main>
    </v-app>
</template>
