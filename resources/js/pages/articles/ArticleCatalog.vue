<script setup>
import Tag from "@/components/Tag.vue"
import Article from "@/components/Article.vue"
import {onMounted, ref} from "vue"
import {useRouter} from "vue-router"

const router = useRouter()
const articles = ref([])
const currentPage = ref(1)
const total = ref(0)
const isLoading = ref(false)
const perPage = ref(10)

const loadAllArticles = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(`/api/articles?page=${currentPage.value}&per_page=${perPage.value}`)
        articles.value = response.data.data
        currentPage.value = response.data.current_page
        total.value = response.data.last_page
    } catch (error) {
        console.error("Articles loading error: ", error)
    } finally {
        isLoading.value = false
    }
};

const onPageChange = () => {
    loadAllArticles()
};

const goToArticle = (slug) => {
    router.push({name: "articleDetail", params: {slug}})
};

onMounted(loadAllArticles)
</script>

<template>
    <v-container class="mt-3 mb-6">
        <v-row>
            <v-col cols="12" sm="4">
                <Tag/>
            </v-col>

            <v-col cols="12" sm="8">
                <v-row>
                    <v-col
                        cols="12"
                        v-for="(article, index) in articles"
                        :key="index"
                        class="mb-4"
                    >
                        <Article
                            :article="article"
                            @click="goToArticle(article.slug)"
                        />
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

        <!--todo make paginate component -->
        <v-row justify="center">
            <v-col cols="12" class="text-center">
                <v-pagination
                    v-model="currentPage"
                    :length="total"
                    next-icon="mdi-menu-right"
                    prev-icon="mdi-menu-left"
                    class="mb-5"
                    @update:model-value="onPageChange"
                ></v-pagination>
            </v-col>
        </v-row>
    </v-container>
</template>
