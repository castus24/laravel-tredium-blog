<script setup>
import {ref} from "vue"
import Header from '@/components/user/common/Header.vue'
import Footer from '@/components/user/common/Footer.vue'
import Sidebar from '@/components/user/common/Sidebar.vue'

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
            <router-view />
        </v-main>

        <Footer/>
    </v-app>
</template>
