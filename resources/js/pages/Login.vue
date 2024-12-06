<script setup>
import {ref} from 'vue'
import {useAuthStore} from '../stores/auth'
import {useRouter} from 'vue-router'
import trediumLogo from '../assets/images/tredium_logo_tp_white.png'

const authStore = useAuthStore()
const router = useRouter()

const passwordVisible = ref(false)
const email = ref('')
const password = ref('')

const register = () => router.push({name: 'register'})

const login = async () => {
    try {
        await authStore.login({
            email: email.value,
            password: password.value
        });

        router.push({name: 'home'})
    } catch (error) {
        console.error(error)
    }
}
</script>

<template>
    <v-container class="mb-5">
        <v-img
            class="mx-auto"
            max-width="228"
            :src="trediumLogo"
        ></v-img>

        <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >
            <v-card-title class="d-flex justify-center mb-4">Sign In</v-card-title>

            <!--            <v-alert v-if="errors" type="error" dismissible>-->
            <!--                {{ errors }}-->
            <!--            </v-alert>-->

            <v-form>
                <v-text-field
                    v-model="email"
                    label="Email"
                    type="email"
                    density="comfortable"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="password"
                    label="Password"
                    density="comfortable"
                    hint="At least 8 characters"
                    required
                    :type="passwordVisible ? 'text' : 'password'"
                    :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                    @click:append="passwordVisible = !passwordVisible"
                ></v-text-field>

                <v-btn
                    elevation="0"
                    class="text-caption text-blue mb-5"
                    href="#"
                >
                    Forgot login password?
                </v-btn>

                <v-btn
                    class="mb-8"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    block
                    @click="login"
                >
                    Log In
                </v-btn>
            </v-form>

            <v-card-text class="text-center">
                <v-btn
                    v-if="!authStore.isAuthenticated"
                    variant="plain"
                    class="text-blue"
                    @click="register"
                >
                    Sign up now
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-btn>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<style scoped>
/* Дополнительные стили для страницы логина */
</style>
