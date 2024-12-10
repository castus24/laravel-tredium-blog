<script setup>
import {computed, ref} from 'vue'

const icons = ref([
    'mdi-facebook',
    'mdi-twitter',
    'mdi-linkedin',
    'mdi-instagram'
]);

const currentYear = computed(() => {
    return new Date().getFullYear();
})
</script>

<template>
    <v-footer class="text-center d-flex flex-column">
        <v-container>
            <v-row justify="space-between">
                <v-col>
                    <v-card
                        elevation="4"
                        class="mb-4 footer-card"
                        max-width="360"
                        rounded="1.7"
                        variant="text"
                    >
                        <v-col>
                            <v-card-title>
                                <h1>Tredium Blog</h1>
                            </v-card-title>
                            <v-card-text>
                                <p>@ {{ currentYear }} All rights reserved</p>
                            </v-card-text>
                        </v-col>
                    </v-card>
                </v-col>

                <v-col class="d-flex justify-center align-center flex-column">
                    <v-container>
                        <v-row justify="center">
                            <v-btn
                                v-for="icon in icons"
                                :key="icon"
                                :icon="icon"
                                class="mx-4"
                                variant="text"
                            ></v-btn>
                        </v-row>
                    </v-container>
                    <p>Made using Laravel and Vuetify</p>
                </v-col>
            </v-row>
        </v-container>
    </v-footer>
</template>
