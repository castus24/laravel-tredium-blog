<script setup>
import {useAuthStore} from '@/stores/auth.js'
import {useRouter} from "vue-router"

const authStore = useAuthStore()
const router = useRouter()
const logout = () => {
    authStore.logout()
    router.push({name: 'home'})
}
</script>

<template>
    <div class="d-flex flex-column justify-space-between fill-height">
        <div>
            <v-list>
                <v-list-item
                    prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
                    subtitle="sandra_a88@gmailcom"
                    title="Sandra Adams"
                ></v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item prepend-icon="mdi-folder" title="Profile" :to="{name: 'profile'}"></v-list-item>
                <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me"></v-list-item>
                <v-list-item prepend-icon="mdi-star" title="Starred"></v-list-item>
            </v-list>
        </div>

        <div class="align-bottom">
            <v-divider></v-divider>

            <div class="mt-5 mb-5 text-center">
                <v-btn
                    width="200"
                    v-if="!authStore.isAuthenticated"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :to="{name: 'login'}"
                >
                    Login
                </v-btn>
                <v-btn
                    width="200"
                    v-if="authStore.isAuthenticated"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    @click="logout"
                >
                    Logout
                </v-btn>
            </div>
        </div>
    </div>
</template>
