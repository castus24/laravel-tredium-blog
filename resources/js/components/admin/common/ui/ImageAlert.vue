<script setup> //todo make changes on component
import {reactive, ref} from "vue"
import {useToast} from "vue-toastification"

const toast = useToast()
const isLoading = ref(false)

const form = reactive({
    image: null
})

defineProps({
    currentAvatar: String,
})

const emit = defineEmits(["image-updated"])
const submit = async() => {
    console.log("Avatar value:", form.image)
    const formData = new FormData();
    formData.append('image', form.image);

    try {
        const response = await axios.post(`/api/articles/{slug}/upload`, formData, {
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
    <v-container class="d-flex flex-column justify-center align-center">
        <v-row class="justify-center my-1">
            <v-icon color="warning" icon="mdi-alert" size="x-large" />
        </v-row>
        <v-row class="justify-center my-1">
            <span class="text-h6">Image not found!</span>
        </v-row>
        <v-row class="justify-center w-50">

            <v-form>
                <v-row>
                    <v-col>
                        <v-file-input
                            label="Upload"
                            prepend-icon="mdi-camera"
                            variant="solo-filled"
                        ></v-file-input>
                    </v-col>
                    <v-col>
                        <v-btn
                            class="text-center"
                            color="primary"
                            size="large"
                            variant="tonal"
                            @click="submit"
                        >
                            Upload
                        </v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-row>
    </v-container>
</template>
