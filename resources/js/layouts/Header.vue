<script setup>
import {ref} from 'vue'

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
                <v-app-bar-title class="ml-4">Tredium</v-app-bar-title>
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
                        <v-icon>mdi-account</v-icon>
                    </v-tab>
                </v-tabs>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<style scoped>
.v-app-bar {
    position: fixed !important;
    top: 0;
    z-index: 10;
}
</style>
