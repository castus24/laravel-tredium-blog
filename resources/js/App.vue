<script setup>
import Header from './layouts/Header.vue'
import Footer from './layouts/Footer.vue'
import Sidebar from './layouts/Sidebar.vue'
import {ref} from "vue"

const drawer = ref(false)
</script>

<template>
    <v-app>
        <Header @sidebar-drawer="drawer=!drawer"/>

        <v-navigation-drawer
            v-model="drawer"
            location="right"
            width="320"
            temporary
        >
            <Sidebar/>
        </v-navigation-drawer>

        <v-main>
            <router-view></router-view>
        </v-main>

        <Footer/>
    </v-app>
</template>
