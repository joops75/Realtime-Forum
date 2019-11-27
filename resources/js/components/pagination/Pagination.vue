<template>
    <v-container v-if="lastPage > 1" class="text-xs-center">
        <v-layout justify-center>
            <v-flex xs8>
                <v-card @click="getPage(current_page)">
                    <v-card-text>
                        <v-pagination
                            v-model="current_page"
                            :length="lastPage"
                        ></v-pagination>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    props: ['getPage', 'currentPage', 'lastPage'],
    data() {
        return {
            current_page: this.currentPage
        }
    }
}
</script>