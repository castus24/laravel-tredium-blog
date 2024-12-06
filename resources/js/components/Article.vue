<script setup>
import {ref} from 'vue'

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
});

const isSelected = ref(false)
const isLoading = ref(false)

const like = async () => {
    // isLoading.value = true;
    // try {
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
        class="home-card"
        elevation="5"
        height="500"
    >
        <v-row class="article-image">
            <v-img
                :src="article.main_image"
                cover
            ></v-img>
        </v-row>
        <v-row class="article-content d-flex flex-column justify-space-between">
            <v-col class="card-content mt-3 px-4">
                <v-card-text class="card-title">
                    {{ article.title }}
                </v-card-text>
                <v-card-text class="card-text">
                    {{ article.content.length > 100 ? article.content.substring(0, 100) + '...' : article.content }}
                </v-card-text>
            </v-col>
            <v-col class="article-actions d-flex justify-space-between">
                <v-chip
                    prepend-icon="mdi-eye-outline"
                >
                    1312
                </v-chip>
                <v-chip>
                    <v-btn
                        variant="plain"
                        :icon="isSelected ? 'mdi-heart' : 'mdi-heart-outline'"
                        @click.stop="like"
                    ></v-btn>
                </v-chip>
            </v-col>
        </v-row>
    </v-card>
</template>

<style scoped>
.home-card {
    transition: transform 0.3s;
}

.home-card:hover {
    transform: translateY(-5px);
}

.article-image {
    overflow: hidden;
    height: 50%;
}

.article-actions {
    padding: 0 30px 30px 30px;
}

.card-title {
    word-break: break-all;
    font-size: large;
    font-weight: bolder;
    padding-bottom: 0;
    transition: color 0.3s;
}

.card-text {
    color: #757575;
    margin-top: 10px;
}

.card-title:hover {
    color: #2196F3;
}
</style>
