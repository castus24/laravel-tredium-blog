<script setup>
import {reactive, ref} from "vue"
import {useToast} from 'vue-toastification'
import trediumLogo from "@/assets/images/tredium_logo_tp_white.png";

const toast = useToast()

const form = reactive({
    email: null
});
const isLoading = ref(false)

const submit = async() => {
    isLoading.value = true
    try {
        const response = await axios.post('/api/user/password/email', form)

        if (response){
            toast.success(response.data.message)
        }
    } catch (error) {
        const errorMessage = error.response.data.message
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
            <v-card-title class="d-flex justify-center mb-4">Forgot password?</v-card-title>

            <v-form>
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    type="email"
                    :disabled="isLoading"
                    density="comfortable"
                    required
                ></v-text-field>

                <v-card
                    class="mb-6"
                    color="surface-variant"
                    variant="tonal"
                >
                    <v-card-text class="text-medium-emphasis text-caption">
                        Please enter your email address. You will receive a link to create a new password via email.
                    </v-card-text>
                </v-card>

                <v-btn
                    :disabled="isLoading"
                    :to="{ name: 'login'}"
                    elevation="0"
                    class="text-caption text-blue mb-5"
                >
                    Back to login page
                </v-btn>

                <v-btn
                    class="mb-8"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :loading="isLoading"
                    :disabled="isLoading"
                    block
                    @click="submit"
                >
                    Get password
                </v-btn>
            </v-form>
        </v-card>
    </v-container>
</template>
