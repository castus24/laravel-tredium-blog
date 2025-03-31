<script setup> //todo need delete after optimization
import {reactive, ref} from "vue"
import {useToast} from "vue-toastification"
import axios from "@/plugins/axios";

const toast = useToast()
const isLoading = ref(false)

const form = reactive({
    avatar: null
})

defineProps({
    currentImage: String,
})

const emit = defineEmits(["image-updated"])
const submit = async () => {
    console.log("Avatar value:", form.avatar)
    const formData = new FormData();
    formData.append('avatar', form.avatar);

    try {
        const response = await axios.post('/api/users/image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        toast.success(response.data.message)
        emit("image-updated", response.data.data.avatar)
    } catch (error) {
        toast.error(error.response.data.message)
    } finally {
        isLoading.value = false
    }
}
</script>

<template>
    <v-container>
        <v-form>
            <v-row>
                <v-col>
                    <v-file-input
                        v-model="form.avatar"
                        label="Avatar"
                        placeholder="Pick an avatar"
                        accept="image/*"
                        prepend-icon="mdi-camera"
                        outlined
                        required
                    />
                </v-col>
                <v-col>
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
                </v-col>
            </v-row>
        </v-form>
    </v-container>
</template>
