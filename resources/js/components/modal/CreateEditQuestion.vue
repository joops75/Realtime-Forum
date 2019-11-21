<template>
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
    >
        <v-card>
            <v-container>
                <v-card-title>
                    <div class="headline">{{ mode }} Question</div>
                </v-card-title>
                <v-form @submit.prevent="handleSubmit">
                    <span v-if="errors.title" class="red--text">{{ errors.title[0] }}</span>
                    <v-text-field
                        label="Title"
                        v-model="question.title"
                        type="text"
                        required
                    ></v-text-field>

                    <span v-if="errors.category_id" class="red--text">{{ errors.category_id[0] }}</span>
                    <v-autocomplete
                        :items="categories"
                        item-text="name"
                        item-value="id"
                        v-model="question.category_id"
                        color="white"
                        label="Category"
                    ></v-autocomplete>

                    <span v-if="errors.body" class="red--text">{{ errors.body[0] }}</span>
                    <vue-simplemde v-model="question.body" />
                    
                    <v-card-actions>
                        <v-btn icon type="submit" :disabled="!isValid">
                            <v-icon color="teal">save</v-icon>
                        </v-btn>
                        
                        <v-btn icon @click="dialog = false">
                            <v-icon>cancel</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            question: {},
            dialog: false,
            mode: 'Create',
            categories: [],
            errors: {}
        }
    },
    created() {
        EventBus.$on('showQuestionModal', question => {
            this.getCategories();
            this.question = question || { body: '' };
            this.mode = question ? 'Edit' : 'Create';
            this.dialog = true;
        })
    },
    methods: {
        handleSubmit() {
            this.errors = {};
            axios({
                method: this.mode === 'Create' ? 'post' : 'put',
                url: this.mode === 'Create' ? '/api/question' : `/api/question/${this.question.slug}`,
                data: this.question
            })
                .then(res => {
                    this.dialog = false;
                    // navigate away and then back to refresh page without hard reload
                    this.$router.push('/loading')
                        .then(() => this.$router.push(res.data.path));
                })
                .catch(err => {
                    const { errors } = err.response.data;
                    if (errors) {
                        this.errors = errors;
                    }
                    Exception.handle(err)
                });
        },
        getCategories() {
            axios.get('/api/category')
                .then(res => this.categories = res.data.data)
                .catch(err => Exception.handle(err));
        }
    },
    computed: {
        isValid() {
            return this.question.title && this.question.body && this.question.category_id;
        }
    }
}
</script>