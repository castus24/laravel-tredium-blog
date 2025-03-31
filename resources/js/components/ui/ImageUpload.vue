<script setup>
import {computed, reactive, ref} from "vue";
import {useToast} from "vue-toastification";

const toast = useToast()
const isLoading = ref(false)

const form = reactive({
    image: null
})

const props = defineProps({
    entity: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(["image-updated"])

const apiUrl = computed(() => {
    switch (props.entity.type) {
        case 'user':
            return '/api/users/image'
        case 'article':
            return `/api/articles/${props.entity.slug}/image`
        default:
            throw new Error('Unsupported entity type')
    }
})

const upload = async () => {
    if (!form.image) {
        toast.error('Please select an image before uploading')
        return
    }

    const formData = new FormData();
    formData.append('image', form.image);

    try {
        const {data} = await axios.post(apiUrl.value, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        toast.success(data.message)
        emit("image-updated", data.data.main_image)
    } catch (error) {
        toast.error(error.data.message)
    } finally {
        isLoading.value = false
    }
}
</script>

<template>
    <v-sheet
        class="pa-5 text-center mx-auto bg-primary"
        elevation="3"
        max-width="400"
        rounded="lg"
        width="100%"
    >
        <v-icon
            class="mb-5"
            color="warning"
            icon="mdi-alert"
            size="36"
        />

        <h2 class="text-h5 mb-6">Image not found</h2>

        <v-divider class="mb-4"></v-divider>

        <v-form class="d-flex align-center justify-space-between">
            <v-file-input
                v-model="form.image"
                label="Upload image"
                accept="image/*"
                prepend-icon="mdi-camera"
                :loading="isLoading"
                outlined
                required
                variant="underlined"
                class="flex-grow-1 mr-4"
            ></v-file-input>
            <v-btn
                color="green-darken-3"
                :disabled="isLoading"
                :loading="isLoading"
                @click="upload"
            >
                <v-icon>mdi-arrow-up-bold</v-icon>
            </v-btn>
        </v-form>
    </v-sheet>
</template>
