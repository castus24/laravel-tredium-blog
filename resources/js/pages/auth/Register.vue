<script setup>
import {ref, computed, reactive} from 'vue'
import {useAuthStore} from '@/stores/auth.js'
import {useRouter} from 'vue-router'
import trediumLogo from '@/assets/images/tredium_logo_tp_white.png'
import {useToast} from 'vue-toastification'

const authStore = useAuthStore()
const router = useRouter()
const toast = useToast()

const step = ref(1)
const isPasswordVisible = ref(false);
const isPasswordConfirmationVisible = ref(false);
const isLoading = ref(false)

const form = reactive({
    email: null,
    password: null,
    password_confirmation: null,
})

const titles = {
    1: 'Sign Up',
    2: 'Create a password',
    3: 'Account created',
};

const currentTitle = computed(() => titles[step.value]);

const isFormValid = computed(() => {
    if (step.value === 1) {
        return form.email !== ''
    }
    if (step.value === 2) {
        return form.password !== '' && form.password === form.password_confirmation
    }
    return true;
});

const nextStep = () => {
    if (step.value < 3) step.value++
};

const previousStep = () => {
    if (step.value > 1) step.value--
};

const register = async () => {
    try {
        if (!isFormValid.value) {
            toast.warning('Please ensure all fields are valid.');
            return;
        }

        const response = await authStore.register({
            email: form.email,
            password: form.password,
            password_confirmation: form.password_confirmation
        });

        if (response) {
            toast.success(response.message)
            setTimeout(() => {
                router.push({ name: 'login' })
            }, 2000);
        } else {
            toast.warning('Unexpected response from server')
        }
    } catch (error) {
        console.log(error.message)
        const errorMessage = error.response?.error || 'Произошла ошибка регистрации'

        toast.error(errorMessage)
        setTimeout(() => {
            router.push({ name: 'register' })
        }, 2000);
    }
}
</script>

<template>
    <v-container>
        <v-img
            class="mx-auto"
            max-width="228"
            :src="trediumLogo"
        ></v-img>

        <v-card
            class="mx-auto"
            max-width="500"
            rounded="lg"
        >
            <v-card-title class="text-h6 font-weight-regular justify-space-between mt-3">
                {{ currentTitle }}
            </v-card-title>

            <v-window v-model="step">
                <v-window-item :value="1" eager>
                    <v-card-text>
                        <v-text-field
                            v-model="form.email"
                            label="Email"
                            type="email"
                            required
                        ></v-text-field>
                        <v-btn
                            elevation="0"
                            class="text-caption text-blue"
                            :to="{ name: 'login' }"
                        >
                            I'm already have an account
                        </v-btn>
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="2" eager>
                    <v-card-text>
                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            required
                            hint="At least 8 characters"
                            :type="isPasswordVisible ? 'text' : 'password'"
                            :append-icon="isPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="isPasswordVisible = !isPasswordVisible"
                        ></v-text-field>
                        <v-text-field
                            v-model="form.password_confirmation"
                            label="Confirm password"
                            required
                            hint="At least 8 characters"
                            :type="isPasswordConfirmationVisible ? 'text' : 'password'"
                            :append-icon="isPasswordConfirmationVisible ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="isPasswordConfirmationVisible = !isPasswordConfirmationVisible"
                        ></v-text-field>
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="3" eager>
                    <div class="pa-4 text-center">
                        <v-img
                            class="mb-4"
                            height="128"
                            :src="trediumLogo"
                            contain
                        ></v-img>
                        <h3 class="text-h6 font-weight-light mb-2">
                            Welcome to Tredium
                        </h3>
                        <span class="text-caption text-grey">Registration successful! Redirecting to login...</span>
                    </div>
                </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn
                    v-if="step > 1"
                    variant="text"
                    size="large"
                    @click="previousStep"
                >
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="step < 2"
                    color="blue-darken-3"
                    size="large"
                    variant="text"
                    :disabled="!isFormValid"
                    @click="nextStep"
                >
                    Next
                </v-btn>
                <v-btn
                    v-if="step === 2"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :disabled="!isFormValid || isLoading"
                    :loading="isLoading"
                    @click="register"
                >
                    Sign Up
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>
