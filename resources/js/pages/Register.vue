<script setup>
import {ref, computed} from 'vue'
import {useAuthStore} from '../stores/auth'
import {useRouter} from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const step = ref(1)
const passwordVisible = ref(false)

const currentTitle = computed(() => {
    switch (step.value) {
        case 1:
            return 'Sign-up'
        case 2:
            return 'Create a password'
        default:
            return 'Account created'
    }
});

const isFormValid = computed(() => {
    if (step.value === 1) {
        return email.value !== ''
    }
    if (step.value === 2) {
        return password.value !== '' && password.value === confirmPassword.value
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
        if (password.value !== confirmPassword.value) {
            throw new Error('Passwords do not match')
        }
        await authStore.register({
            name: name.value,
            email: email.value,
            password: password.value,
        });

        router.push({name: 'Login'})
    } catch (error) {
        console.error(error.message)
    }
}
</script>

<template>
    <v-container>
        <v-img
            class="mx-auto my-6"
            max-width="228"
            src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
        ></v-img>

        <v-card
            class="mx-auto"
            max-width="500"
            rounded="lg"
        >
            <v-card-title class="text-h6 font-weight-regular justify-space-between mt-3">{{
                    currentTitle
                }}
            </v-card-title>

            <!--            <v-alert v-if="errors" type="error" dismissible>-->
            <!--                {{ errors }}-->
            <!--            </v-alert>-->

            <v-window v-model="step">
                <v-window-item :value="1">
                    <v-card-text>
                        <v-text-field
                            v-model="email"
                            label="Email"
                            type="email"
                            required
                        ></v-text-field>
                        <span class="text-caption text-grey-darken-1">This is the email you will use to login to your Vuetify account</span>
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="2">
                    <v-card-text>
                        <v-text-field
                            v-model="password"
                            label="Password"
                            required
                            hint="At least 8 characters"
                            :type="passwordVisible ? 'text' : 'password'"
                            :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="passwordVisible = !passwordVisible"
                        ></v-text-field>
                        <v-text-field
                            v-model="confirmPassword"
                            label="Confirm password"
                            required
                            hint="At least 8 characters"
                            :type="passwordVisible ? 'text' : 'password'"
                            :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="passwordVisible = !passwordVisible"
                        ></v-text-field>
                        <span class="text-caption text-grey-darken-1">Please enter a password for your account</span>
                    </v-card-text>
                </v-window-item>

                <v-window-item :value="3">
                    <div class="pa-4 text-center">
                        <v-img
                            class="mb-4"
                            height="128"
                            src="https://cdn.vuetifyjs.com/images/logos/v.svg"
                            contain
                        ></v-img>
                        <h3 class="text-h6 font-weight-light mb-2">
                            Welcome to Vuetify
                        </h3>
                        <span class="text-caption text-grey">Thanks for signing up!</span>
                    </div>
                </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn
                    v-if="step > 1"
                    variant="text"
                    @click="previousStep"
                >
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="step < 3"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :disabled="!isFormValid"
                    @click="nextStep"
                >
                    Next
                </v-btn>
                <v-btn
                    v-if="step === 2"
                    color="blue-darken-3"
                    size="large"
                    variant="flat"
                    :disabled="!isFormValid"
                    @click="register"
                >
                    Sign Up
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<style scoped>
/* Дополнительные стили для страницы регистрации */
</style>
