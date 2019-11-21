<template>
    <v-container>
        <v-alert v-if="errors.name" :value="true" type="error">
            {{ errors.name[0] }}
        </v-alert>
        <v-form @submit.prevent="handleSubmit">

            <v-text-field
                label="Category Name"
                v-model="name"
                type="text"
                required
            ></v-text-field>

            <v-btn
                color="teal"
                type="submit"
                :disabled="!name"
            >{{ mode }} Category</v-btn>

            <v-btn
                v-if="slug"
                @click="cancelEdit"
            >Cancel Edit</v-btn>
        </v-form>
        
        <v-card>
            <v-toolbar class="mt-2" color="indigo" dark dense>
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>

            <v-list>
                <div v-for="(category, i) in categories" :key="category.id">
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-btn icon @click="setData(category.name, category.slug, i)">
                                <v-icon v-if="i == index" color="red">edit</v-icon>
                                <v-icon v-else color="orange">edit</v-icon>
                            </v-btn>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>{{ category.name }}</v-list-tile-title>
                        </v-list-tile-content>

                        <v-list-tile-action>
                            <v-btn icon @click="destroy(category.slug, i)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                    <v-divider v-if="i + 1 < categories.length" />
                </div>
            </v-list>
        </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            name: null,
            slug: null,
            index: null,
            categories: [],
            errors: {}
        }
    },
    created() {
        if (!User.isAdmin()) {
            return this.$router.push('/forum');
        }
        
        axios.get('/api/category')
            .then(res => this.categories = res.data.data)
            .catch(err => Exception.handle(err));
    },
    methods: {
        handleSubmit() {
            this.errors = {};
            this.slug ? this.editCategory() : this.createCategory();
        },
        createCategory() {
            axios.post('/api/category', { name: this.name })
                .then(res => {
                    this.categories.unshift(res.data);
                    this.setData();
                })
                .catch(err => {
                    const { errors } = err.response.data;
                    if (errors) {
                        this.errors = errors;
                    }
                    Exception.handle(err)
                });
        },
        editCategory() {
            axios.put(`/api/category/${this.slug}`, { name: this.name })
                .then(res => {
                    this.categories[this.index] = res.data;
                    this.setData();
                })
                .catch(err => {
                    const { errors } = err.response.data;
                    if (errors) {
                        this.errors = errors;
                    }
                    Exception.handle(err)
                });
        },
        destroy(slug, index) {
            this.errors = {};
            axios.delete(`/api/category/${slug}`)
                .then(res => this.categories.splice(index, 1))
                .catch(err => Exception.handle(err));
        },
        cancelEdit() {
            this.setData();
        },
        setData(name, slug, index) {
            this.errors = {};
            this.name = name || null;
            this.slug = slug || null;
            this.index = index === undefined ? null : index;
        }
    },
    computed: {
        mode() {
            return this.slug ? 'Edit' : 'Create';
        }
    }
}
</script>