<script setup>
import {ref} from 'vue'

defineProps({
    article: {
        type: Object,
        required: true,
    },
});

const isSelected = ref(false)
const isLoading = ref(false)

const like = async () => {
    // try {
    // isLoading.value = true;
    //     const response = await axios.get(`/api/article`);
    //     this.articles = response.data.data;
    // } catch (error) {
    //     console.error("Ошибка like:", error);
    // } finally {
    //     isLoading.value = false;
    // }
};
</script>

<template>
    <v-card
        class="d-flex flex-column"
        elevation="5"
        height="450"
    >
        <div>
            <v-img
                :src="article.main_image"
                cover
                height="250"
            ></v-img>
        </div>
        <div class="d-flex flex-column justify-space-between fill-height px-3 py-3">
            <v-card-title class="py-3">
                {{ article.title }}
            </v-card-title>

            <v-card-text
                class="d-flex align-center"
            >
                {{ article.content.length > 100 ? article.content.substring(0, 100) + '...' : article.content }}
            </v-card-text>

            <v-card-actions class="d-flex justify-space-between px-4">
                <v-chip
                    prepend-icon="mdi-eye-outline"
                >
                    1312
                </v-chip>
                <v-chip
                >
                    <v-btn
                        variant="text"
                        :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'"
                        @click.stop="like"
                    ></v-btn>
                </v-chip>
            </v-card-actions>
        </div>
    </v-card>
</template>
