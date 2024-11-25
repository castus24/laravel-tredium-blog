<script>
import Tag from "../components/Tag.vue";

export default {
    components: {
        Tag
    },
    data() {
        return {
            articles: [],
            currentPage: 1,
            total: 0
        };
    },
    mounted() {
        this.loadArticles();
    },
    methods: {
        async loadArticles() {
            try {
                const response = await axios.get(`/api/articles?page=${this.currentPage}`);
                this.articles = response.data.data;
                this.currentPage = response.data.current_page;
                this.total = response.data.last_page;
            } catch (error) {
                console.error("Articles loading error: ", error);
            }
        },
        onPageChange() {
            this.loadArticles();
        },
        goToArticle(slug) {
            this.$router.push({name: "articleDetail", params: {slug}});
        },
    },
};
</script>

<template>
    <v-container class="mt-5">
        <v-row>
            <v-col cols="12" sm="4">
                <Tag></Tag>
            </v-col>

            <v-col
                cols="12"
                sm="8"
                class="d-flex flex-column"
            >
                <v-card
                    v-for="(article, index) in articles"
                    :key="index"
                    class="home-card mb-6"
                    elevation="5"
                    @click="goToArticle(article.slug)"
                >
                    <v-row class="article-image">
                        <v-img
                            :src="article.main_image"
                            height="500"
                            cover
                        >
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular color="grey-lighten-4" indeterminate></v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </v-row>
                    <v-row class="card-content">
                        <v-card-text class="card-title">{{ article.title }}</v-card-text>
                        <v-card-text class="card-text">{{ article.content }}</v-card-text>
                    </v-row>
                    <v-row justify="space-between" class="article-content">
                        <v-btn variant="plain">
                            <v-icon icon="mdi-heart-outline" size="x-large"></v-icon>
                        </v-btn>
                        <v-btn variant="plain">
                            <v-icon icon="mdi-eye" size="x-large"></v-icon>
                        </v-btn>
                    </v-row>
                </v-card>
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

<style scoped>
.card-title {
    transition: color 0.3s;
    font-weight: bold;
    padding: 16px;
    white-space: normal;
    overflow: visible;
    word-wrap: break-word;
    font-size: 24px;
}

.card-title:hover {
    color: #2196F3;
}

.card-content {
    padding: 0 20px 0 20px;
}

.card-text {
    overflow: visible;
    text-overflow: clip;
    padding: 0 16px 16px;
    color: #555;
    white-space: normal;
    font-size: 16px;
}

.home-card {
    display: flex;
    flex-direction: column;
    transition: transform 0.3s, border-color 0.3s;
}

.home-card:hover {
    border-color: #2196F3;
    transform: translateX(5px);
}

.article-image {
    height: 70%;
}

.article-content {
    height: 30%;
    padding: 20px;
}
</style>
