<template>
    <div>
        <v-card class="mt-2" v-for="question in questions" :key="question.title">
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">
                        <router-link :to="question.path">
                            {{ question.title }}
                        </router-link>
                    </h3>
                    <div class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</div>
                </div>

                <v-spacer></v-spacer>

                <v-card color="teal">
                        <v-card-text class="font-weight-bold white--text">{{ question.reply_count }} replies</v-card-text>
                    </v-card>
            </v-card-title>

            <v-card-text>{{ question.body }}</v-card-text>
        </v-card>

        <Pagination :getPage="getPage" :currentPage="pagination.current_page" :lastPage="pagination.last_page" />
    </div>
</template>

<script>
import Pagination from '../pagination/Pagination';

export default {
    components: { Pagination },
    data() {
        return {
            questions: [],
            pagination: { current_page: 1 }
        }
    },
    created() {
        this.getPage(this.pagination.current_page);
    },
    methods: {
        getPage(requestedPage) {
            axios.get(`/api/question?page=${requestedPage}`)
                .then(res => {
                    this.questions = res.data.data;
                    this.pagination = res.data.meta;
                })
                .catch(err => Exception.handle(err));
            }
    }
}
</script>