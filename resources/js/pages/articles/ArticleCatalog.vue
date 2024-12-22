<script setup>
import TagForm from "@/components/TagForm.vue"
import ArticleForm from "@/components/ArticleForm.vue"
import {onMounted, ref, watch} from "vue"
import {useRouter} from "vue-router"

const router = useRouter()
const articles = ref([])
const currentPage = ref(1)
const total = ref(0)
const isLoading = ref(false)
const perPage = ref(10)

const loadAllArticles = async () => {
    try {
        isLoading.value = true;
        const {data} = await axios.get(`/api/articles?page=${currentPage.value}&per_page=${perPage.value}`)
        articles.value = data.data
        currentPage.value = data.meta.current_page
        total.value = data.meta.last_page
    } catch (error) {
        console.error("Articles loading error: ", error)
    } finally {
        isLoading.value = false
    }
};

watch(currentPage, () => {
    loadAllArticles();
});

const goToArticle = (slug) => {
    router.push({name: "articleDetail", params: {slug}})
};

onMounted(loadAllArticles)
</script>

<template>
    <v-container class="mt-3 mb-6">
        <v-row>
            <v-col v-if="isLoading" cols="12" sm="4">
                <v-progress-linear
                    :size="50"
                    color="blue-darken-3"
                    indeterminate
                ></v-progress-linear>
            </v-col>
            <v-col v-else cols="12" sm="4">
                <TagForm />
            </v-col>

            <v-col v-if="isLoading" cols="12" sm="8">
                <v-skeleton-loader
                    class="mx-auto border"
                    height="450"
                    type="image, article"
                ></v-skeleton-loader>
            </v-col>
            <v-col v-else cols="12" sm="8">
                <v-row>
                    <v-col
                        cols="12"
                        v-for="(article, index) in articles"
                        :key="index"
                        class="mb-4"
                    >
                        <ArticleForm
                            :article="article"
                            @click="goToArticle(article.slug)"
                        />
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <v-row justify="center">
            <v-col cols="12" class="text-center">
                <v-pagination
                    v-model="currentPage"
                    :length="total"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"
                    class="mb-5"
                ></v-pagination>
            </v-col>
        </v-row>
    </v-container>
</template>
