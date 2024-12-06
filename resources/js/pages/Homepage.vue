<script setup>
import Article from "../components/Article.vue"
import {onMounted, ref} from "vue"
import {useRouter} from "vue-router"

const router = useRouter()
const articles = ref([])
const images = ref([
    "https://picsum.photos/seed/image1/3100/800",
    "https://picsum.photos/seed/image2/3100/800",
    "https://picsum.photos/seed/image3/3100/800",
    "https://picsum.photos/seed/image4/3100/800",
])
const isLoading = ref(false);

const loadArticles = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(`/api`)
        articles.value = response.data.data;
    } catch (error) {
        console.error("Articles loading error: ", error)
    } finally {
        isLoading.value = false;
    }
};

const goToArticle = (slug) => {
    router.push({name: "articleDetail", params: {slug}})
};

onMounted(loadArticles)
</script>

<template>
    <v-carousel
        height="400"
        show-arrows="hover"
        cycle
        hide-delimiter-background
        class="mt-6"
    >
        <v-carousel-item
            v-for="(image, index) in images"
            :key="index"
            :src="image"
        ></v-carousel-item>
    </v-carousel>

    <v-container class="mt-3 mb-6">
        <v-row>
            <v-col
                cols="12"
                sm="4"
                v-for="(article, index) in articles"
                :key="index"
            >
                <Article
                    :article="article"
                    @click="goToArticle(article.slug)"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
</style>
