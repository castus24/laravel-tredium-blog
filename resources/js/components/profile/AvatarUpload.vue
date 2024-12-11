<script setup>
import {reactive, ref} from "vue"
import {useToast} from "vue-toastification"
import axios from "@/plugins/axios";

const toast = useToast()
const isLoading = ref(false)

const form = reactive({
    avatar: null
})

defineProps({
    currentAvatar: String,
})

const emit = defineEmits(["avatar-updated"])
const submit = async() => {
    console.log("Avatar value:", form.avatar)
    const formData = new FormData();
    formData.append('avatar', form.avatar);

    try {
        const response = await axios.post('/api/user/avatar/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        toast.success(response.data.message)
        emit("avatar-updated", response.data.data.avatar)
    } catch (error) {
        toast.error(error.response.data.message)
    } finally {
        isLoading.value = false
    }
}
</script>

<template>
    <v-container width="500">
        <v-form>
            <v-file-input
                v-model="form.avatar"
                label="Avatar"
                placeholder="Pick an avatar"
                accept="image/*"
                prepend-icon="mdi-camera"
                outlined
                required
            />
            <v-btn
                class="text-center"
                color="blue-darken-3"
                size="large"
                variant="tonal"
                :disabled="isLoading"
                :loading="isLoading"
                @click="submit"
            >
                Upload
            </v-btn>
        </v-form>
    </v-container>
</template>
