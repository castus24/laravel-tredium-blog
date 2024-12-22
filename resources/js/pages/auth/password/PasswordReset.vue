<script setup>
import {reactive, ref} from "vue";
import {useToast} from 'vue-toastification'
import trediumLogo from "@/assets/images/tredium_logo_tp_white.png";
import {useRouter, useRoute} from 'vue-router'

const router = useRouter()
const route = useRoute()
const toast = useToast()
const passwordVisible = ref(false)

const form = reactive({
    token: route.query.token,
    email: route.query.email,
    password: null,
    password_confirmation: null,
});
const isLoading = ref(false);
const submit = async () => {
    try {
        if (form.password !== form.password_confirmation) {
            toast.error('Passwords do not match');
            return;
        }

        if (form.password.length < 8) {
            toast.error('Password must be at least 8 characters long');
            return;
        }
        console.log(form)

        const response = await axios.post('/api/users/password/reset', form)

        toast.success(response.data.message)
        await router.push({name: 'login'})
    } catch (error) {
        const errorMessage = error.response?.data?.message

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
            <v-card-title class="d-flex justify-center mb-4">Password Reset</v-card-title>

            <v-form>
                <v-text-field
                    v-model="form.password"
                    label="New Password"
                    required
                    hint="At least 8 characters"
                    :type="passwordVisible ? 'text' : 'password'"
                    :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                    @click:append="passwordVisible = !passwordVisible"
                ></v-text-field>
                <v-text-field
                    v-model="form.password_confirmation"
                    label="Confirm New Password"
                    required
                    hint="At least 8 characters"
                    :type="passwordVisible ? 'text' : 'password'"
                    :append-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                    @click:append="passwordVisible = !passwordVisible"
                ></v-text-field>

                <v-btn
                    class="mb-8"
                    color="blue-darken-3"
                    size="large"
                    variant="tonal"
                    :loading="isLoading"
                    block
                    @click="submit"
                >
                    Set new password
                </v-btn>
            </v-form>
        </v-card>
    </v-container>
</template>
