<script setup>
import {reactive, ref} from 'vue'
import {useAuthStore} from '@/stores/auth.js'
import {useRouter} from 'vue-router'
import trediumLogo from '@/assets/images/tredium_logo_tp_white.png'
import {useToast} from 'vue-toastification'

const authStore = useAuthStore()
const router = useRouter()
const toast = useToast()

const isVisible = ref(false)
const isLoading = ref(false)

const form = reactive({
    email: null,
    password: null
})

const login = async () => {
    try {
        isLoading.value = true
        await authStore.login({
            email: form.email,
            password: form.password
        });

    } catch (error) {
        const errorMessage = error.response?.error || 'Account login error';

        toast.error(errorMessage)
    } finally {
        isLoading.value = false
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

            <v-form>
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    density="comfortable"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    label="Password"
                    density="comfortable"
                    hint="At least 8 characters"
                    required
                    :type="isVisible ? 'text' : 'password'"
                    :append-icon="isVisible ? 'mdi-eye-off' : 'mdi-eye'"
                    @click:append="isVisible = !isVisible"
                ></v-text-field>

                <v-btn
                    elevation="0"
                    class="text-caption text-blue mb-5"
                    :to="{ name: 'resetLink'}"
                >
                    Forgot login password?
                </v-btn>

                <v-btn
                    class="mb-8"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :loading="isLoading"
                    :disabled="isLoading"
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
                    :to="{ name: 'register' }"
                >
                    Sign up now
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-btn>
            </v-card-text>
        </v-card>
    </v-container>
</template>
