<script>
export default {
    props: {
        slug: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            article: null,
            isLoading: true,
            subject: "",
            body: "",
            submitting: false,
            error: null,
            success: null,
        };
    },
    mounted() {
        this.loadArticle();
    },
    methods: {
        async loadArticle() {
            try {
                const response = await axios.get(`/api/articles/${this.slug}`)
                ;
                this.article = response.data;
                this.isLoading = false;
            } catch (error) {
                console.error("Article detail loading error: ", error);
                this.error = "Article detail loading error.";
                this.isLoading = false;
            }
        },
        async submitComment() {
            this.submitting = true;
            this.error = null;
            this.success = null;

            try {
                const response = await axios.post(`/api/articles/${this.slug}/comment`, {
                            subject: this.subject,
                            body:
                            this.body,
                        }
                    )
                ;
                this.success = response.data.message;
                this.subject = "";
                this.body = "";
            } catch (err) {
                this.error = "Failed to submit comment. Please try again.";
            } finally {
                this.submitting = false;
            }
        },
    },
};
</script>

<template>
    <v-container class="mt-5">
        <v-row>
            <v-col cols="12">
                <v-card v-if="isLoading" class="text-center">
                    <v-card-text>
                        <v-progress-circular indeterminate></v-progress-circular>
                        <p>Загрузка статьи...</p>
                    </v-card-text>
                </v-card>

                <v-alert v-else-if="error" type="error" dismissible>
                    {{ error }}
                </v-alert>

                <v-card v-else elevation="5" class="article-detail">
                    <v-card-title class="text-h4 font-weight-bold">
                        {{ article.title }}
                    </v-card-title>
                    <v-card-subtitle class="text-body-2 mb-4">
                        {{ article.created_at }}
                    </v-card-subtitle>
                    <v-card-text class="article-content">
                        {{ article.content }}
                    </v-card-text>

                    <v-card-text>
                        <v-form>
                            <v-text-field
                                label="Тема сообщения"
                                v-model="subject"
                                :disabled="submitting"
                                outlined
                                required
                            ></v-text-field>
                            <v-textarea
                                label="Сообщение"
                                v-model="body"
                                :disabled="submitting"
                                outlined
                                required
                            ></v-textarea>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-center align-center text-center mb-4">
                        <v-btn
                            :disabled="submitting"
                            color="blue-darken-3"
                            @click="submitComment"
                        >
                            Отправить
                        </v-btn>
                        <v-progress-circular
                            v-if="submitting"
                            indeterminate
                            color="primary"
                            size="24"
                        ></v-progress-circular>
                    </v-card-actions>
                </v-card>

                <v-alert v-if="error" type="error">{{ error }}</v-alert>
                <v-alert v-if="success" type="success">{{ success }}</v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.article-detail {
    margin-bottom: 32px;
    transition: transform 0.3s, border-color 0.3s;
}

.article-detail:hover {
    border-color: #2196F3;
}

.article-content {
    white-space: pre-wrap;
    color: #333;
    line-height: 1.6;
    font-size: 16px;
}
</style>
