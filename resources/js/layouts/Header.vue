<script setup>
import {computed, ref} from 'vue'
import trediumLogo from '@/assets/images/tredium_logo_tp_white.png'
import {useAuthStore} from "@/stores/auth.js"

const authStore = useAuthStore()
const user = computed(() => authStore.userData)

const tab = ref(null)

const emit = defineEmits(['sidebar-drawer'])
const sidebarDrawer = () => {
    emit('sidebar-drawer')
};
</script>

<template>
    <v-app-bar
        scroll-behavior="elevate"
        location="top"
        class="bg-grey-lighten-5x position-relative"
    >
        <v-container>
            <v-row class="d-flex justify-space-between align-center">
                <v-app-bar-title class="ml-4">
                    <v-img
                        max-width="128"
                        :src="trediumLogo"
                    ></v-img>
                </v-app-bar-title>
                <v-tabs
                    v-model="tab"
                    align-tabs="center"
                    color="blue-darken-3"
                >
                    <v-tab
                        :value="1"
                        link exact :to="{ name: 'home' }">Home
                    </v-tab>
                    <v-tab
                        :value="2"
                        link exact :to="{ name: 'articles' }">Articles catalog
                    </v-tab>
                    <v-tab
                        :value="3"
                        icon
                        @click="sidebarDrawer"
                    >
                        <div v-if="user">
                            <v-avatar size="32">
                                <v-img :src="user.avatar" cover />
                            </v-avatar>
                        </div>
                        <div v-else>
                            <v-icon>mdi-account</v-icon>
                        </div>
                    </v-tab>
                </v-tabs>
            </v-row>
        </v-container>
    </v-app-bar>
</template>
